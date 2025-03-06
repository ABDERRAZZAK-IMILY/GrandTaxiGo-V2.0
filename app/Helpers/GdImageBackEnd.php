<?php

namespace App\Helpers;

use BaconQrCode\Renderer\Image\ImageBackEndInterface;
use BaconQrCode\Renderer\Image\TransformationMatrix;
use BaconQrCode\Renderer\Path\Path;
use BaconQrCode\Renderer\Color\ColorInterface;
use BaconQrCode\Renderer\RendererStyle\Gradient;
use BaconQrCode\Exception\RuntimeException;

class GdImageBackEnd implements ImageBackEndInterface
{
    /**
     * @var string
     */
    private $imageFormat;

    /**
     * @var resource|null
     */
    private $image;

    /**
     * @var int
     */
    private $size;

    /**
     * @param string $imageFormat
     */
    public function __construct(string $imageFormat = 'png')
    {
        $this->imageFormat = $imageFormat;
        $this->image = null;
    }

    /**
     * Starts a new image.
     *
     * If a previous image was already started, previous data get erased.
     */
    public function new(int $size, ColorInterface $backgroundColor) : void
    {
        $this->size = $size;
        $this->image = imagecreatetruecolor($size, $size);
        
        // Set background color
        $rgb = $backgroundColor->toRgb();
        $background = imagecolorallocate(
            $this->image,
            $rgb->getRed(),
            $rgb->getGreen(),
            $rgb->getBlue()
        );
        
        imagefill($this->image, 0, 0, $background);
    }

    /**
     * Transforms all following drawing operation coordinates by scaling them by a given factor.
     *
     * @throws RuntimeException if no image was started yet.
     */
    public function scale(float $size) : void
    {
        // Not implemented for simplicity
    }

    /**
     * Transforms all following drawing operation coordinates by translating them by a given amount.
     *
     * @throws RuntimeException if no image was started yet.
     */
    public function translate(float $x, float $y) : void
    {
        // Not implemented for simplicity
    }

    /**
     * Transforms all following drawing operation coordinates by rotating them by a given amount.
     *
     * @throws RuntimeException if no image was started yet.
     */
    public function rotate(int $degrees) : void
    {
        // Not implemented for simplicity
    }

    /**
     * Pushes the current coordinate transformation onto a stack.
     *
     * @throws RuntimeException if no image was started yet.
     */
    public function push() : void
    {
        // Not implemented for simplicity
    }

    /**
     * Pops the last coordinate transformation from a stack.
     *
     * @throws RuntimeException if no image was started yet.
     */
    public function pop() : void
    {
        // Not implemented for simplicity
    }

    /**
     * Draws a path with a given color.
     *
     * @throws RuntimeException if no image was started yet.
     */
    public function drawPathWithColor(Path $path, ColorInterface $color) : void
    {
        if (null === $this->image) {
            throw new RuntimeException('No image was started');
        }

        $rgb = $color->toRgb();
        $gdColor = imagecolorallocate(
            $this->image,
            $rgb->getRed(),
            $rgb->getGreen(),
            $rgb->getBlue()
        );

        $currentX = 0;
        $currentY = 0;

        foreach ($path as $operation) {
            $name = get_class($operation);
            
            // Handle different path operations
            switch ($name) {
                case 'BaconQrCode\Renderer\Path\Move':
                    $currentX = $operation->getX();
                    $currentY = $operation->getY();
                    break;
                    
                case 'BaconQrCode\Renderer\Path\Line':
                    $endX = $operation->getX();
                    $endY = $operation->getY();
                    
                    imageline(
                        $this->image,
                        (int) $currentX,
                        (int) $currentY,
                        (int) $endX,
                        (int) $endY,
                        $gdColor
                    );
                    
                    $currentX = $endX;
                    $currentY = $endY;
                    break;
                    
                case 'BaconQrCode\Renderer\Path\Close':
                    // Not implemented for simplicity
                    break;
                    
                default:
                    // Other operations not implemented for simplicity
                    break;
            }
        }
    }

    /**
     * Draws a path with a given gradient which spans the box described by the position and size.
     *
     * @throws RuntimeException if no image was started yet.
     */
    public function drawPathWithGradient(
        Path $path,
        Gradient $gradient,
        float $x,
        float $y,
        float $width,
        float $height
    ) : void {
        // Not implemented for simplicity
        // Just use a solid color instead
        $startColor = $gradient->getStartColor();
        $this->drawPathWithColor($path, $startColor);
    }

    /**
     * Ends the image drawing operation and returns the resulting blob.
     *
     * This should reset the state of the back end and thus this method should only be callable once per image.
     *
     * @throws RuntimeException if no image was started yet.
     */
    public function done() : string
    {
        if (null === $this->image) {
            throw new RuntimeException('No image was started');
        }

        ob_start();
        
        if ($this->imageFormat === 'png') {
            imagepng($this->image);
        } elseif ($this->imageFormat === 'jpg' || $this->imageFormat === 'jpeg') {
            imagejpeg($this->image);
        } elseif ($this->imageFormat === 'gif') {
            imagegif($this->image);
        } else {
            imagepng($this->image);
        }
        
        $blob = ob_get_contents();
        ob_end_clean();
        
        imagedestroy($this->image);
        $this->image = null;
        
        return $blob;
    }
} 