<?php

namespace SevenShores\RouteFinder;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;

class RouteFindCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'route:find
                            {search : The route to search for}
                            {--trim : Whether or not to trim extra whitespace}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Find registered routes';

    /**
     * Handle the artisan command.
     *
     * @return int
     */
     public function handle()
    {
        $process = new Process("php artisan route:list");
        $process->run();

        $results = $this->searchResults(
            $this->argument('search'),
            explode("\n", $process->getOutput())
        );

        if (! empty($results)) {
          print $results;
        } else {
          $this->info("No results.");
        }

        return $process->getExitCode();
    }

    /**
     * Format the output into a string.
     *
     * @param  string  $search
     * @param  array  $output
     * @return string
     */
    private function searchResults($search, $output)
    {
        return collect($output)->filter(function ($line) use ($search) {
            return str_contains($line, $search);
        })->map(function ($line) use ($search) {
            return $this->formatLine($line, $search);
        })->implode(PHP_EOL);
    }

    /**
     * Format a search result line.
     *
     * @param  string  $line
     * @param  string  $search
     * @return mixed
     */
    private function formatLine($line, $search)
    {
        if ($this->option('trim')) {
            $line = preg_replace('/\s\s+/', ' ', $line);
        }

        return $this->highlight($search, $line);
    }

    /**
     * Highlight a string inside of a string.
     *
     * @param  string  $needle
     * @param  string  $haystack
     * @return mixed
     */
    private function highlight($needle, $haystack)
    {
        return str_replace(
            $needle,
            "\e[93m{$needle}\e[39m",
            $haystack
        );
    }
}
