<?php

class HeaderOverrideFilter implements RequestFilter
{

    public function postRequest(\SS_HTTPRequest $request, \SS_HTTPResponse $response, \DataModel $model)
    {
        $overrideHeaders = Config::inst()->forClass("HeaderOverrideFilter")->get("Headers");
        if ($overrideHeaders && is_array($overrideHeaders)) {
            foreach ($overrideHeaders as $header => $value) {
                $response->removeHeader($header);
                $response->addHeader($header, $value);
            }
        }

        return true;
    }

    public function preRequest(\SS_HTTPRequest $request, \Session $session, \DataModel $model)
    {
        return true;
    }
}