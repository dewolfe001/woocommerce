<?php

/**
 * Tests using the points gateway to checkout.
 *
 * @package WordPoints_WooCommerce
 * @since   1.2.0
 */

wc_empty_cart();
WC()->cart->empty_cart();

$I = new AcceptanceTester( $scenario );
$I->wantTo( 'Checkout with points gateway.' );

$product_id = $I->hadCreatedAProduct();

$I->hadCreatedAPointsType();
$I->hadCreatedAPointsType( array( 'name' => 'Test' ) );

$I->hadCreatedAPointsCoupon( 'test' );

$I->hadSetPointsConversionRate();
$I->hadSetPointsConversionRate( 'test', 50 );

$user_id = $I->amLoggedInAsCustomer();

wordpoints_set_points( $user_id, 10000, 'test', 'test' );

$I->amOnPage( str_replace( home_url(), '', get_permalink( $product_id ) ) );
$I->click( 'Add to cart' );
$I->amOnPage( str_replace( home_url(), '', wc_get_page_permalink( 'checkout' ) ) );
$I->waitForElementVisible( '[name=wordpoints_points-points-type]' );
$I->selectOption( 'wordpoints_points-points-type', 'Test' );
$I->click( 'Place order' );
$I->waitForElementNotVisible( '.blockOverlay' );
$I->see( 'Thank you. Your order has been received.' );
PHPUnit_Framework_Assert::assertSame( 8750, wordpoints_get_points( $user_id, 'test' ) );

// EOF
