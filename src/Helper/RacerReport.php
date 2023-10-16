<?php

namespace App\Helper;

use App\Exception\NotFoundRacerException;

class RacerReport
{
    private array $racers = [];

    public function __construct(string $racersFile, string $timesFile)
    {
        $this->loadRacersFromFile($racersFile);
        $this->loadTimesFromFile($timesFile);
    }

    private function loadRacersFromFile( string $filename): void
    {
        $racersData = file_get_contents($filename);
        $lines = explode("\n", $racersData);

        foreach ($lines as $line) {
            if (empty($line)) {
                continue;
            }
            $values = explode("_", $line);

            $this->racers[] = array(
                'abbr' => $values[0],
                'name' => $values[1],
                'team' => $values[2]
            );
        }
    }

    private function loadTimesFromFile( string $filename): void
    {
        $timesData = file_get_contents($filename);
        $lines = explode("\n", $timesData);

        foreach ($lines as $line) {
            $abbr = substr($line, 0, 3);
            $dateTime = substr($line, 3);

            foreach ($this->racers as &$racer) {
                if ($racer['abbr'] == $abbr) {
                    $racer['abbr'] = $abbr;
                    $racer['date'] = substr($dateTime, 0, 10);
                    $racer['time'] = strtotime(substr($dateTime, 11));
                }
            }
        }
    }

    /**
     * @throws NotFoundRacerException
     */
    public function getRacerByName(string $name): ?array
    {
        foreach ($this->racers as $racer) {
            if ($racer['name'] === $name) {
                return $racer;
            }
        }
        return throw new NotFoundRacerException('Not found driver');
    }

    private function getSortedRacers(): array
    {
        $times = [];

        foreach ($this->racers as $racer) {
            $times[$racer['abbr']][] = $racer['time'];
        }

        foreach ($times as &$racer_times) {
            sort($racer_times);
        }

        usort($this->racers, function ($a, $b) use ($times) {
            $firstTime = $times[$a['abbr']][0];
            $secondTime = $times[$b['abbr']][0];
            return $firstTime - $secondTime;
        });

        return $this->racers;
    }

    public function getTopRacers(int $numRacers = 15): array
    {
        return array_slice($this->getSortedRacers(), 0, $numRacers);
    }

    public function getLosersRacers(int $numRacers = 15): array
    {
        return array_slice($this->getSortedRacers(), $numRacers);
    }

}
