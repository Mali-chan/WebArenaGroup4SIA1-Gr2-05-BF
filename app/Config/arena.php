<?php

/**
 * Arena configuration file
 */

/**
 * Global constants
 */
$config = array(
    // Arena width
    'Arena.width' => 15,
    // Arena height
    'Arena.height' => 10);

/**
 * Convenience functions
 */

/**
 * Checks if coordinates are within arena bounds
 * @param type $coordinate_x
 * @param type $coordinate_y
 * @return boolean
 */
function isWithinArena($coordinate_x, $coordinate_y) {
    if (($coordinate_x < 0) || ($coordinate_x >= Configure::read('Arena.width')) ||
            ($coordinate_y < 0) || ($coordinate_y >= Configure::read('Arena.height'))) {
        return false;
    }
    return true;
}

/**
 * Generate a random coordinate_x
 * @return int
 */
function randCoordinateX() {
    return rand(0, Configure::read('Arena.width') - 1);
}

/**
 * Generate a random coordinate_y
 * @return int
 */
function randCoordinateY() {
    return rand(0, Configure::read('Arena.height') - 1);
}
