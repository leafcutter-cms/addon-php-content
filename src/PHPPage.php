<?php
namespace Leafcutter\Addons\Leafcutter\PHPContent;

use Leafcutter\Pages\Page;
use Leafcutter\URL;

class PHPPage extends Page
{
    protected $sandbox;

    public function __construct(URL $url, ?Sandbox $sandbox=null)
    {
        if (!$sandbox) {
            throw new \Exception("PHPPage requires a Sandbox object");
        }
        $this->sandbox = $sandbox;
        parent::__construct($url);
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
