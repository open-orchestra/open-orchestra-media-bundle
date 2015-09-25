<?php

namespace OpenOrchestra\Media\FFmpegMovie;

use ffmpeg_movie;

/**
 * Interface FFmpegMovieFactoryInterface
 */
interface FFmpegMovieFactoryInterface
{
    /**
     * @param string $path
     * @param bool   $persistent
     *
     * @return ffmpeg_movie
     */
    public function create($path, $persistent);
}
