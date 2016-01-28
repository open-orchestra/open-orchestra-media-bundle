<?php

namespace OpenOrchestra\Media\Helper;

use OpenOrchestra\Media\Model\MediaInterface;

class MediaWithFormatExtractor implements MediaWithFormatExtractorInterface
{
    /**
     * Extract media id and media format from stored string
     *
     * @param string $mediaInfo
     *
     * @return array
     */
    public function extractInformation($mediaInfo)
    {
        $mediaInfo = explode(self::SEPARATOR, $mediaInfo);

        $extractedInfo = array('id' => $mediaInfo[0], 'format' => MediaInterface::MEDIA_ORIGINAL);
        if (isset($mediaInfo[1])) {
            $extractedInfo['format'] = $mediaInfo[1];
        }

        return $extractedInfo;
    }
}
