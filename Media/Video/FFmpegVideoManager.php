<?php

namespace OpenOrchestra\Media\Video;

use FFMpeg\FFMpeg;
use FFMpeg\Coordinate\TimeCode;

/**
 * Class FFmpegVideoManager
 */
class FFmpegVideoManager implements VideoManagerInterface
{
    protected $ffmpeg;

    /**
     * @param FFMpeg $FFmpeg
     */
    public function __construct(FFMpeg $FFmpeg)
    {
        $this->ffmpeg = $FFmpeg;
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
