<?php

namespace OpenOrchestra\Media\Imagick;

/**
 * Interface OrchestraImagickInterface
 */
interface OrchestraImagickInterface
{
    /**
     * @param mixed|null $files
     */
    public function __construct($files = null);

    /**
     * @param string $format
     *
     * @return bool
     */
    public function setImageFormat($format);

    /**
     * @param int $compression
     *
     * @return bool
     */
    public function setCompression($compression);

    /**
     * @param string|null $filename
     *
     * @return bool
     */
    public function writeImage($filename = null);

    /**
     * @param int $compression
     *
     * @return bool
     */
    public function setImageCompression($compression);

    /**
     * @param int $quality
     *
     * @return bool
     */
    public function setImageCompressionQuality($quality);

    /**
     * @return bool
     */
    public function stripImage();

    /**
     * @param mixed $background
     *
     * @return bool
     */
    public function setImageBackgroundColor($background);

    /**
     * @return int
     */
    public function getImageWidth();

    /**
     * @return int
     */
    public function getImageHeight();

    /**
     * @param int   $columns
     * @param int   $rows
     * @param int   $filter
     * @param float $blur
     * @param bool|false $bestfit
     *
     * @return bool
     */
    public function resizeImage($columns, $rows, $filter, $blur, $bestfit = false);

    /**
     * @param int $width
     * @param int $height
     * @param int $x
     * @param int $y
     *
     * @return bool
     */
    public function cropImage($width, $height, $x, $y);

}
