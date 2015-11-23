<?php

namespace OpenOrchestra\Media\Video;

/**
 * Interface VideoManagerInterface
 */
interface VideoManagerInterface
{
    /**
     * @param string $pathVideo
     * @param string $pathFrame
     * @param int    $timeFrame
     */
    public function createFrame($pathVideo, $pathFrame, $timeFrame);
}
