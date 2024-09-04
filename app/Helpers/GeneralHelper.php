<?php

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization; // Import the facade

if (!function_exists('getLanguages')) {
    function getLanguages()
    {
        $languages = \App\Models\Language::get();

        return $languages;
    }
}

//get cities

if (!function_exists('getCities')) {
    function getCities()
    {
        $cities = \App\Models\City::get();

        return $cities;
    }
}

//get districts

if (!function_exists('getDistricts')) {
    function getDistricts($cityId = null)
    {
        $districts = \App\Models\District::query();
        if ($cityId) {
            $districts = $districts->where('city_id', $cityId);
        }
        $districts = $districts->get();

        return $districts;
    }
}

if (!function_exists('getActiveLanguages')) {
    function getActiveLanguages()
    {
    
        $ret = [];
        foreach (\LaravelLocalization::getSupportedLocales() as $key => $locale) {
            $ret[$key] = $locale['name'];
        }
        return $ret;

        
    }
}

if (!function_exists('getCurrentLocale')) {
    function getCurrentLocale()
    {
        $laravelLocalization = new LaravelLocalization();
        $currentLocale = $laravelLocalization->getCurrentLocale();

        return $currentLocale;
    }
}

if (!function_exists('prepareVariants')) {
    function prepareVariants($requestVariants)
    {
        $variants = [];
        if ($requestVariants == null) {
            return $variants;
        }

        foreach ($requestVariants as $requestVariant) {

            // Kontrol etmek istediğimiz anahtarlar
            $expectedKeys = ['name', 'is_required'];
            $requestVariant = json_decode($requestVariant, true);

            // Ana verileri kontrol et
            foreach ($expectedKeys as $key) {
                if (!array_key_exists($key, $requestVariant)) {
                    throw new InvalidArgumentException("Missing or empty '$key' in variant.");
                }
            }

            $variant = [];
            $variant['name'] = $requestVariant['name'];
            $variant['is_required'] = $requestVariant['is_required'];
            $variant['sub_options'] = [];

            foreach ($requestVariant['sub_options'] as $subOption) {
                // Kontrol etmek istediğimiz alt anahtarlar
                $subOptionKeys = ['name', 'price'];

                // Alt verileri kontrol et
                foreach ($subOptionKeys as $subKey) {

                    if (!array_key_exists($subKey, $subOption)) {
                        throw new InvalidArgumentException("Missing or empty '$subKey' in sub_option.");
                    }
                }

                $variant['sub_options'][] = [
                    'name' => $subOption['name'],
                    'price' => $subOption['price'] ? $subOption['price'] : 0
                ];
            }

            $variants[] = $variant;
        }

        return $variants;
    }
}


if (!function_exists('_languageAttribute')) {
    function _languageAttribute($attribute)
    {
        return $attribute . '_' . \LaravelLocalization::getCurrentLocale();
    }
}
if (!function_exists('_otherLangs')) {
    function _otherLangs() {
        return Arr::except(
            _getSupportedLanguagesAsArray(),
            _clang()
        );
    }
}

if (!function_exists('_clang')) {
    function _clang()
    {
        return strtolower(\LaravelLocalization::getCurrentLocale());
    }
}
if (!function_exists('_getSupportedLanguagesAsArray')) {
    function _getSupportedLanguagesAsArray()
    {
        $ret = [];
        foreach (\LaravelLocalization::getSupportedLocales() as $key => $locale) {
            $ret[$key] = $locale['name'];
        }
        return $ret;
    }
}
if (!function_exists('_getSupportedLanguageKeysAsArray')) {
    function _getSupportedLanguageKeysAsArray()
    {

        $ret = [];
        foreach (\LaravelLocalization::getSupportedLocales() as $key => $locale) {
            $ret[] = $key;
        }
        return $ret;

    }
}

if (!function_exists('_getContentLanguageCode')) {
    function _getContentLanguageCode()
    {
        return str_replace('_', '-', config('laravellocalization.supportedLocales.' . _clang() . '.regional'));

    }
}

if (!function_exists('localizedAttributeName')) {
    function localizedAttributeName($fieldKey, $langKey = null)
    {
        $langKey = $langKey ?? config('app.locale');
        return $fieldKey . "_" . $langKey;
    }
}

if (!function_exists('langValue')) {

    function langValue($fileName, $key, $langCode, $b = '')
    {
        $value = Lang::get($fileName . '.' . $key, array(), $langCode);
        if ($value != $fileName . '.' . $key) {
            $b = $value;
        }
        return $b;
    }
}

if (!function_exists('langName')) {
    function langName($fileName, $key, $langCode, $b = '')
    {
        $value = str_replace('.', '][', preg_replace('/\.(.*?)\[/', '[\\1][', $key . '[' . $langCode . ']'));
        return $value;
    }
}

if (!function_exists('_e')) {
    function _e($value)
    { // Tek tırnak yok et
        $result = str_replace('\'', '&#039;', $value);
        return $result;
    }
}

if (!function_exists('_shareMultiSlugLocalizedUrls')) {
    function _shareMultiSlugLocalizedUrls($routename, $parameters = [])
    {
        $slugList = [];
    
        foreach (_getSupportedLanguageKeysAsArray() as $supportedLocale) {
            foreach ($parameters as $key => $parameter) {
                $slugList[$supportedLocale]['parameters'][$key] = $parameter->getTranslation('slug', $supportedLocale);
            }

            //if route front.food add restaurant slug
            if($routename == 'front.food') {
                $slugList[$supportedLocale]['parameters']['restaurantSlug'] = $parameter->restaurant->slug;
            }

            $slugList[$supportedLocale]['route'] = $routename;
        }
        View::share('localizedSlugList', $slugList);

        
        
        return $slugList;
    }
}

if (!function_exists('_localizedCurrentUrl')) {
    function _localizedCurrentUrl($lang)
    {
        $localizedSlugList = View::shared('localizedSlugList');
        $routeParameters = Route::current() ? Route::current()->parameters() : [];

        $routeUrl = request()->url();
        $hideDefaultLocaleInURL = !config('laravellocalization.hideDefaultLocaleInURL', false);


        if (isset($localizedSlugList[$lang])) {
            if (isset($localizedSlugList[$lang]['parameters'])) {
                $routeParameters = $localizedSlugList[$lang]['parameters'];
            } else {
                $routeParameters = ['slug' => $localizedSlugList[$lang]['slug']];
            }
            $routeName = $localizedSlugList[$lang]['route'];
            $routeUrl = route($routeName, $routeParameters);
        }

        $localization = app('laravellocalization');
        $url = $localization->getLocalizedURL($lang, $routeUrl, $routeParameters, $hideDefaultLocaleInURL);
        
        return $url;
    }
}

if (!function_exists('pageTitle')) {
    function pageTitle($title = null)
    {
        return $title . ' - ' . 'Trial';
    }
}

if (!function_exists('apiResponse')) {
    function apiResponse($status = true, $data = null)
    {
        return response()->json([
            'success' => $status,
            'data' => $data,
            
        ], 200);
    }
}

if (!function_exists('apiErrorResponse')) {
    function apiErrorResponse($status, $message = null, $code = 400)
    {
        return response()->json([
            'success' => $status,
            'message' => $message,
        ], $code);
    }
}