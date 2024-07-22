<?php

namespace App\Repositories;


use App\Models\Attachment;
use App\Models\Section;

class SectionRepository
{
    public function render($parameters)
    {
        return once(function () use ($parameters) {
            $parameters = explode('.', $parameters);
            $sectionName = array_splice($parameters, 0, 1)[0];

            $section = $this->find($sectionName);

            foreach ($parameters as $parameter) {
                if ($parameter === 'first')
                    $section = $section[0];
                elseif (is_numeric($parameter))
                    $section = $section[$parameter];
                else $section = $section->{$parameter};
            }

            return new Renderable($section);
        });
    }

    private function find($name)
    {
        return once(function () use ($name) {
            return Section::content($name);
        });
    }
}

class Renderable {
    private $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function asWhatItIs(){
        return $this->data;
    }

    public function asAttachment()
    {
        return Attachment::find($this->data);
    }

    public function asString()
    {
        return $this->__toString();
    }

    public function __toString(){
        return (string) $this->data;
    }
}
