<?php

namespace aharen\Language;

use aharen\Language\StorageSession as Session;

class Language
{

    public function validate($code)
    {

        if ($this->isValidLocale($code) === true) {
            $this->setLocale($code);

        } else {
            if ($code !== '404') {
                return redirect($this->getLocaleCode() . '/404')->send();
            }

            $this->setDefaultLocale();
        }
    }

    public function getLocale()
    {
        return (array) $this->locale();
    }

    public function getLocaleName()
    {
        return $this->locale()->name;
    }

    public function getLocaleCode()
    {
        return $this->locale()->code;
    }

    public function getLocaleKeywords()
    {
        return $this->locale()->keywords;
    }

    public function getLocaleDescription()
    {
        return $this->locale()->description;
    }

    protected function locale()
    {
        $code = Session::get('locale');
        return \DB::table('languages')
            ->select(['name', 'code', 'keywords', 'description'])
            ->where([
                'code'   => $code,
                'status' => 'on',
            ])
            ->first();
    }

    protected function isValidLocale($code)
    {
        $language = \DB::table('languages')
            ->select('code')
            ->where([
                'code'   => $code,
                'status' => 'on',
            ])
            ->get();

        return (count($language) <= 0) ? false : true;
    }

    protected function handleNoLocale($code)
    {
        if ($code === null) {
            $this->setDefaultLocale();
        }
    }

    protected function setSessionLocale($code)
    {
        Session::put(['locale' => $code]);
    }

    protected function setDefaultLocale()
    {
        $code = config('app.fallback_locale');
        $this->setLocale($code);
    }

    protected function setLocale($code)
    {
        config(['app.locale' => $code]);
        $this->setSessionLocale($code);
    }
}
