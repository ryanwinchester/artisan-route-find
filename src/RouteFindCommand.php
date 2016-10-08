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
     * @param  array  $output
     * @return string
     */
    private function searchResults($output)
    {
        return collect($output)->filter(function ($line) {
            return str_contains($line, $this->argument('search'));
        })->map(function ($line) {
            return $this->formatLine($line);
        })->implode(PHP_EOL);
    }

    /**
     * Format a search result line.
     *
     * @param  string  $line
     * @return mixed
     */
    private function formatLine($line)
        {
            if ($this->option('trim')) {
                $line = preg_replace('/\s\s+/', ' ', $line);
            }

            // TODO: Add search term highlighting
            // e.g. pseudo-ish code:
            //
            // return str_replace(
            //     $this->argument('search'),
            //     "highlight".$search."/highlight",
            //     $line
            // );

            return $line;
    }
}
