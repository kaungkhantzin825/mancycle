<?php

namespace App\Helpers;

class ImageHelper
{
    /**
     * Get the first image from a listing with fallback
     */
    public static function getListingImage($listing, $index = 0)
    {
        if ($listing->images) {
            $images = json_decode($listing->images, true);
            if ($images && isset($images[$index])) {
                return $images[$index];
            }
        }
        
        // Return placeholder based on category type
        return self::getPlaceholder($listing->category->type ?? 'default');
    }
    
    /**
     * Get all images from a listing
     */
    public static function getListingImages($listing)
    {
        if ($listing->images) {
            $images = json_decode($listing->images, true);
            if ($images && is_array($images)) {
                return $images;
            }
        }
        
        return [self::getPlaceholder($listing->category->type ?? 'default')];
    }
    
    /**
     * Get placeholder image URL based on type
     */
    public static function getPlaceholder($type = 'default')
    {
        // Using placeholder.com service as fallback
        $placeholders = [
            'cars' => 'https://via.placeholder.com/800x600/667eea/ffffff?text=Car',
            'motorcycles' => 'https://via.placeholder.com/800x600/f59e0b/ffffff?text=Motorcycle',
            'second_hand' => 'https://via.placeholder.com/800x600/10b981/ffffff?text=Item',
            'parts-accessories' => 'https://via.placeholder.com/800x600/10b981/ffffff?text=Part',
            'default' => 'https://via.placeholder.com/800x600/6b7280/ffffff?text=No+Image'
        ];
        
        return $placeholders[$type] ?? $placeholders['default'];
    }
    
    /**
     * Check if image URL is valid
     */
    public static function isValidImageUrl($url)
    {
        if (empty($url)) {
            return false;
        }
        
        // Check if it's a valid URL
        if (filter_var($url, FILTER_VALIDATE_URL) === false) {
            return false;
        }
        
        return true;
    }
}
