<?php

namespace OpenOrchestra\Media\FFmpegMovie;

use FFMpeg\FFMpeg;
use FFMpeg\Coordinate\TimeCode;

/**
 * Class FFmpegMovieFrame
 */
class FFmpegMovieFrame implements FFmpegMovieFrameInterface
{
    protected $ffmpeg;

    /**
     * FFmpegMovieFrame constructor.
     */
    public function __construct()
    {
        $this->ffmpeg = FFMpeg::create();
    }

    /**
     * @param string $pathVideo
     * @param string $pathFrame
     * @param int    $timeFrame
     */
    public function createFrame($pathVideo, $pathFrame, $timeFrame)
    {
        $video = $this->ffmpeg->open($pathVideo);
        $video->frame(TimeCode::fromSeconds($timeFrame))
              ->save($pathFrame);
    }
}
