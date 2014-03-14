<?php
/**
 * This file is part of the CoBRA bundle for Claroline Connect.
 * 
 * (c) University of Namur (Cellule TICE) <tice@unamur.be>
 * Author: jmeuriss
 * Date: 12/12/13
 * Time: 11:54
 */
namespace Unamur\CobraBundle\Lib;

use Symfony\Component\HttpKernel\Exception;
class ElexRemoteService
{
    public static function call( $serviceName, $params = array(), $returnType = 'json' )
    {
        try
        {
            $validReturnTypes = array( 'html', 'object', 'objectList', 'string', 'integer', 'boolean', 'error' );
            $url = 'http://tice.det.fundp.ac.be/cobra-dev/services/service_handler_new.php';
            $params['caller'] = 'Claro-sandbox';
            if( sizeof( $params ) )
            {
                $queryString = http_build_query( $params );
            }
            if( !$response = self::elex_http_request( $url . '?verb=' . $serviceName . '&' . $queryString ) )
            {
                throw new CobraRemoteException( 'Unable to access required URL' . $url );
            }
            $response = json_decode( $response );
            if( !in_array( $response->responseType, $validReturnTypes ) )
            {
                throw new CobraRemoteException( 'Unhandled return type' . '&nbsp;:&nbsp;' . $response->responseType );
            }
            if( 'error' == $response->responseType )
            {
                throw new CobraRemoteException( $response->content );
            }
            elseif( 'html' == $response->responseType )
            {
                return $response->content;
            }
            else
            {
                return $response->content;
            }
        }
        catch( Exception $e )
        {
            claro_die( $e->getMessage() );
        }
    }

    public static function elex_http_request( $url )
    {
        if( ini_get( 'allow_url_fopen' ) )
        {
            if( false === $response = @file_get_contents( $url ) )
            {
                return false;
            }
            else
            {
                return $response;
            }
        }
        elseif( function_exists('curl_init') )
        {
            if( !$response = elex_curl_request( $url ) )
            {
                return false;
            }
            else
            {
                return $response;
            }
        }
        else
        {
            throw new CobraRemoteException( "Your PHP install does not support url access." );
        }
    }

    public static function getRemoteTextList( $collectionId )
    {
        $textList = array();
        $params = array( 'collection' => $collectionId );
        $remoteTextObjectList = self::call( 'loadTexts', $params );

        foreach( $remoteTextObjectList as $textObject  )
        {
            $text['id'] = $textObject->id;
            $text['title'] = strip_tags($textObject->title);
            $text['source'] = $textObject->source;
            $textList[] = $text;
        }
        return $textList;
    }
}