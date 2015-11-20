<?php

namespace OpenOrchestra\Media\FFmpegMovie;

/**
 * Interface FFmpegMovieFrameInterface
 */
interface FFmpegMovieFrameInterface
{
    /**
     * @param string $pathVideo
     * @param string $pathFrame
     * @param int    $timeFrame
     */
    public function createFrame($pathVideo, $pathFrame, $timeFrame);
}
