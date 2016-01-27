<?php

namespace OpenOrchestra\Media\Helper;

interface MediaWithFormatExtractorInterface
{
    const SEPARATOR = '-format-';

    /**
     * Extract media id and media format from stored string
     *
     * @param string $mediaInfo
     *
     * @return array
     */
    public function extractInformation($mediaInfo);
}