<?php

namespace OpenOrchestra\Media\FFmpegMovie;

use ffmpeg_movie;

/**
 * Class FFmpegMovieFactory
 */
class FFmpegMovieFactory implements FFmpegMovieFactoryInterface
{
    /**
     * @param string $path
     * @param bool $persistent
     *
     * @return ffmpeg_movie
     */
    public function create($path, $persistent)
    {
        return new ffmpeg_movie($path, $persistent);
    }

}
