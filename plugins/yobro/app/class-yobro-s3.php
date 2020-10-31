<?php

namespace YoBro\App;

use Aws\S3\S3Client;
use Aws\S3\Exception\S3Exception;

/**
* Class YoBro_S3_Handler
*
* @author      RedQTeam
* @category    Admin
* @package     YoBro\App
* @version     1.0.2
* @since       1.0.0
*/

class YoBro_S3_Handler{

	public function __construct(){
		$yobro_settings = get_option('yo_bro_settings', true);
		if((isset($yobro_settings)) && !empty($yobro_settings)){
			if(isset($yobro_settings['aws_access_key_id']) && $yobro_settings['aws_access_key_id'] != '' && isset($yobro_settings['aws_secret_access_key'])  && $yobro_settings['aws_secret_access_key'] != ''){
				$this->accessId = $yobro_settings['aws_access_key_id'];
				$this->accessSecret = $yobro_settings['aws_secret_access_key'];
				if (isset($yobro_settings['aws_bucket_name']) && $yobro_settings['aws_bucket_name'] != '') {
					$this->bucketName = $yobro_settings['aws_bucket_name'];
				}
				if (isset($yobro_settings['aws_bucket_region']) && $yobro_settings['aws_bucket_region'] != '') {
					$this->bucketRegion = $yobro_settings['aws_bucket_region'];
				}
			}
		}
		$this->s3Client = new S3Client([
			'version'     => 'latest',
			'region'      => $this->bucketRegion,
			'credentials' => [
				'key'    => 	$this->accessId,
				'secret' => $this->accessSecret,
			],
		]);
	}

	public function createBucket($bucket_name = 'yobro_new_bucket'){
		try {
			$result = $this->s3Client->createBucket([
				'Bucket' => $bucket_name,
			]);
			return $result;
		}catch (S3Exception $e) {
			$error = [
				'status_code' => 400,
				'message' => $e->getAwsErrorMessage()
			];
			echo json_encode( $error );
		}
	}
	public function getBucketList(){
		try {
			$buckets = $this->s3Client->listBuckets();
			return $buckets;
		}catch (S3Exception $e) {
			$error = [
				'status_code' => 400,
				'message' => $e->getAwsErrorMessage()
			];
			echo json_encode( $error );
		}
	}
	public function getBucketPolicy($bucketName){
		try {
			$resp = $this->s3Client->getBucketPolicy([
				'Bucket' => $bucketName
			]);
			return $resp->get('Policy');
		} catch (S3Exception $e) {
			$error = [
				'status_code' => 400,
				'message' => $e->getAwsErrorMessage()
			];
			echo json_encode( $error );
		}
	}

	public function uploadImageToS3($image_temp_url, $thumbnail){
		if($thumbnail === 'true'){
			$image = wp_get_image_editor( $image_temp_url );
			if ( ! is_wp_error( $image ) ) {
				$image->resize( 500, true );
				$image->save(YOBRO_DIR.'/temp_thumbnail.jpg');
				$image_temp_url = YOBRO_DIR.'/temp_thumbnail.jpg';
			}
		}
		try {
			$result = $this->s3Client->putObject(array(
				'Bucket'      => $this->bucketName,
				'Key'         => microtime(),
				'SourceFile'  => $image_temp_url,
				'ACL'         => 'public-read',
				'ContentType' => 'plain/text',
			));
			if(file_exists(YOBRO_DIR.'/temp_thumbnail.jpg')){
				unlink(YOBRO_DIR.'/temp_thumbnail.jpg');
			}
			return $result['ObjectURL'];
		} catch (S3Exception $e) {
			if(file_exists(YOBRO_DIR.'/temp_thumbnail.jpg')){
				unlink(YOBRO_DIR.'/temp_thumbnail.jpg');
			}
			$error = [
				'status_code' => 400,
				'message' => $e->getAwsErrorMessage()
			];
			echo json_encode( $error );
		}
	}

	public function getImageFromS3($key){
		try {
			$result = $this->s3Client->getObject(array(
				'Bucket' => 'yo-bro-test-bucket',
				'Key'    => $key,
			));
			return $result;
		} catch (S3Exception $e) {
			$error = [
				'status_code' => 400,
				'message' => $e->getAwsErrorMessage()
			];
			echo json_encode( $error );
		}
	}
}
