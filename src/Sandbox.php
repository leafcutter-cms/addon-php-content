<?php
namespace Leafcutter\Addons\Leafcutter\PHPContent;

use Leafcutter\Leafcutter;
use Leafcutter\Pages\Page;
use Leafcutter\URL;

class Sandbox
{
    protected $file, $url, $leafcutter;
    protected $usedParams = [];
    protected $rawContentType = 'html';

    public function __construct(string $file, URL $url, Leafcutter $leafcutter)
    {
        $this->file = $file;
        $this->url = $url;
        $this->leafcutter = $leafcutter;
        $this->page = new PHPPage($this->url,$this);
        $this->page()->setDynamic(true);
    }

    public function execute()
    {
        ob_start();
        include $this->file();
        $this->page()->setRawContent(ob_get_contents(), $this->rawContentType);
        ob_end_clean();
        $url = $this->page()->url();
        $url->setQuery($this->usedParams());
        $this->page()->setUrl($url);
    }

    protected function file(): string
    {
        return $this->file;
    }

    protected function url(): URL
    {
        return $this->url;
    }

    protected function leafcutter(): Leafcutter
    {
        return $this->leafcutter;
    }

    public function page(): Page
    {
        return $this->page;
    }

    protected function usedParams(): array
    {
        return $this->usedParams;
    }

    protected function param(string $name)
    {
        if ($value = @$this->url->query()[$name]) {
            $this->usedParams[$name] = $value;
            return $value;
        }
        return null;
    }
}
