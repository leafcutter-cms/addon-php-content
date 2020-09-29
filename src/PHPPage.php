<?php
namespace Leafcutter\Addons\Leafcutter\PHPContent;

use Leafcutter\Leafcutter;
use Leafcutter\Pages\Page;
use Leafcutter\URL;
use Symfony\Component\Yaml\Yaml;

class PHPPage extends Page
{
    protected $sandbox;

    public function __construct(URL $url, ?Sandbox $sandbox = null)
    {
        if (!$sandbox) {
            throw new \Exception("PHPPage requires a Sandbox object");
        }
        $this->sandbox = $sandbox;
        // do parent construct
        parent::__construct($url);
        // parse content of file for @meta tags
        preg_replace_callback('/<!--@meta(.+?)-->/ms', function ($match) use ($url) {
            try {
                $meta = Yaml::parse($match[1]);
                $this->metaMerge($meta, true);
            } catch (\Throwable $th) {
                Leafcutter::get()->logger()->notice('Failed to parse meta yaml content for PHPPage ' . $url);
            }
            return $match[0];
        }, file_get_contents($this->sandbox->file()));
    }

    public function generateContent(): string
    {
        if ($this->generatedContent === null) {
            $this->sandbox->execute();
            parent::generateContent();
        }
        return $this->generatedContent;
    }
}
