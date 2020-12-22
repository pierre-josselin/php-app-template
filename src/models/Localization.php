<?php
class Localization {
    private $locale;
    private $localizations;
    
    public function __construct(string $locale) {
        $this->locale = $locale;
        $path = Configuration::ROOT . "/locales/{$locale}.yml";
        $content = file_get_contents($path);
        $this->localizations = yaml_parse($content);
    }
    
    public function getText(string $id, array $variables = []) {
        if(isset($this->localizations[$id])) {
            $text = $this->localizations[$id];
            foreach($variables as $key => $value) {
                $text = str_replace("{" . $key . "}", $value, $text);
            }
            return $text;
        } else {
            return $id;
        }
    }
    
    public function getLocale() {
        return $this->locale;
    }
}