<?php

namespace aharen\Language;

use aharen\Language\StorageSession as Session;

class Language
{

    public function validate($code)
    {
        if (in_array($code, config('language.ignore'))) {
            $this->setDefaultLocale();
        } else {

            if ($this->isValidLocale($code) === true) {
                $this->setLocale($code);

            } else {
                if ($code !== '404') {
                    return redirect($this->getLocaleCode() . '/')->send();
                }

                $this->setDefaultLocale();
            }
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
        return $this->getSessionLocale();
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
        $code = $this->getSessionLocale();
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

    protected function getSessionLocale()
    {
        return Session::get('locale');
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
