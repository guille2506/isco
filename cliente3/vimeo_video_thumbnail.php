<?php

    /**
     * Gets the thumbnail url for a vimeo video using the video id. This only works for public videos.
     *
     * @param string $id        The video id.
     * @param string $thumbType Thumbnail image size. supported sizes: small, medium (default) and large.
     *
     * @return string|bool
     */

    function getVimeoVideoThumbnailByVideoId( $id = '', $thumbType = 'medium' ) {

        $id = trim( $id );

        if ( $id == '' ) {
            return FALSE;
        }

        $apiData = unserialize( file_get_contents( "http://vimeo.com/api/v2/video/$id.php" ) );

        if ( is_array( $apiData ) && count( $apiData ) > 0 ) {

            $videoInfo = $apiData[ 0 ];

            switch ( $thumbType ) {
                case 'small':
                    return $videoInfo[ 'thumbnail_small' ];
                    break;
                case 'large':
                    return $videoInfo[ 'thumbnail_large' ];
                    break;
                case 'medium':
                    return $videoInfo[ 'thumbnail_medium' ];
                default:
                    break;
            }

        }

        return FALSE;

    }

    // Example usage ...

    $videoId = '145154247';

    echo '<img src="'.getVimeoVideoThumbnailByVideoId($videoId,'small').'" title="Small Thumbnail">'.'<br>';
    echo '<img src="'.getVimeoVideoThumbnailByVideoId($videoId,'medium').'" title="Medium Thumbnail">'.'<br>';
    echo '<img src="'.getVimeoVideoThumbnailByVideoId($videoId,'large').'" title="Large Thumbnail">'.'<br>';