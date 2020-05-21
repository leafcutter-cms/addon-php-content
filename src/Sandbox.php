<?php
namespace Leafcutter\Addons\Leafcutter\PHPContent;

use Leafcutter\Leafcutter;
use Leafcutter\Pages\Page;
use Leafcutter\URL;

class Sandbox
{
    private $file, $url, $leafcutter;
    private $usedParams = [];

    public function __construct(string $file, URL $url, Leafcutter $leafcutter)
    {
        $this->file = $file;
        $this->url = $url;
        $this->leafcutter = $leafcutter;
        $this->page = new Page($this->url, '');
        $this->page()->setDynamic(true);
    }

    public function execute()
    {
        ob_start();
        include $this->file();
        $this->page()->setContent(ob_get_contents());
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
