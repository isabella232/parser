<?php declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: jeroen
 * Date: 16-7-18
 * Time: 15:44
 */

namespace Elgentos\Parser;

class StoryBook
{

    /** @var []Story */
    private $stories = [];
    /** @var int */
    private $storyCount = 0;

    public function addStories(Story ... $stories)//: void
    {
        array_walk($stories, function ($story) {
            $this->stories[] = $story;
            $this->storyCount++;
        });
    }

    /**
     * Tell how many stories are in the book
     *
     * @return int
     */
    public function getStories(): int
    {
        return $this->storyCount;
    }

    protected function getMetric(string $metric): int
    {
        return array_reduce($this->stories, function($cnt, Story $story) use ($metric) {
            return $cnt + $story->{$metric}();
        }, 0);
    }

    /**
     * Tell how many pages in the book
     *
     * @return int
     */
    public function getPages(): int
    {
        return $this->getMetric('getPages');
    }

    /**
     * Tell how often stories are read
     *
     * @return int
     */
    public function getRead(): int
    {
        return $this->getMetric('getRead');
    }

    /**
     * Tell how many pages where successful
     *
     * @return int
     */
    public function getSuccessful(): int
    {
        return $this->getMetric('getSuccessful');
    }

}