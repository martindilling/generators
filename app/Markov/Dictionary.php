<?php
declare(strict_types=1);

namespace App\Markov;

use SplFileObject;
use Illuminate\Support\Str;

class Dictionary
{
    private string $path;
    private string $slug;
    private string $title = '';
    private array $lines = [];

    public function __construct(string $path)
    {
        $this->path = $path;
        $this->slug = basename($path);
    }

    public function path() : string
    {
        return $this->path;
    }

    public function slug() : string
    {
        return $this->slug;
    }

    public function title() : string
    {
        if (!$this->title) {
            $firstLine = (new SplFileObject($this->path))->fgets();
            $this->title = Str::replaceFirst('# ', '', $firstLine ?: '# Untitled');
        }

        return $this->title;
    }

    public function lines() : array
    {
        if (!$this->lines) {
            $this->lines = array_filter(
                file($this->path, FILE_IGNORE_NEW_LINES),
                function ($n) : bool {
                    return strpos($n, '#') !== 0 && $n !== '';
                }
            );
        }

        return $this->lines;
    }

}
