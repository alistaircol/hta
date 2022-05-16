<?php declare(strict_types=1);

namespace Tests;

use Alistaircol\Hta\Domain\Basket\Exceptions\BasketTotalFormattingForIso4217NotImplementedException;
use Alistaircol\Hta\Domain\Basket\Exceptions\BasketTotalFormattingInvalidIso4217CodeException;
use Alistaircol\Hta\Domain\Basket\Exceptions\OfferDiscountOutOfBoundsException;
use Alistaircol\Hta\Domain\Basket\Exceptions\ProductPriceOutOfBoundsException;
use Alistaircol\Hta\Domain\Basket\InMemoryBasket;

final class InMemoryBackingStoreBasketTest extends AbstractBasketTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->basket = (new InMemoryBasket())->create();
    }

    public function test_create_new_basket_has_no_items(): void
    {
        $this->assertCount(0, $this->basket->getItems());
    }

    public function test_create_new_basket_total_is_zero(): void
    {
        $this->assertEquals(0, $this->basket->getTotal());
    }

    public function test_creating_a_basket_with_explicit_null_initial_offer(): void
    {
        $basket = (new InMemoryBasket())->create(null);

        $this->assertNull($basket->getAppliedOffer());
    }

    public function test_creating_a_basket_with_initial_offer(): void
    {
        $offer = $this->getOfferTwelveMonthContractTenPercentDiscount();
        $basket = (new InMemoryBasket())->create($offer);

        $this->assertNotNull($basket->getAppliedOffer());
    }

    public function test_empty_basket_total_formatted_implicitly_with_gbp_is_zero(): void
    {
        $total = 0;
        $this->assertEquals('£0.00', $this->basket->getTotalFormatted($total));
    }

    public function test_empty_basket_total_formatted_explicitly_with_gbp_not_all_in_uppercase_is_zero(): void
    {
        $total = 0;
        $this->assertEquals('£0.00', $this->basket->getTotalFormatted($total, 'gbp'));
    }

    public function test_empty_basket_total_formatted_explicitly_with_invalid_iso4217_code_throws_exception(): void
    {
        $this->expectException(BasketTotalFormattingInvalidIso4217CodeException::class);

        $this->basket->getTotalFormatted(0, 'expects a three letter code');
    }

    public function test_empty_basket_total_formatted_explicitly_with_unimplemented_iso4217_code_throws_exception(): void
    {
        $this->expectException(BasketTotalFormattingForIso4217NotImplementedException::class);
        $this->basket->getTotalFormatted(0, 'aaa');
    }

    public function test_product_discounted_price_with_no_discount(): void
    {
        $product = $this->getProductFloorplan();
        $offer = $this->getOfferNoDiscount();

        $this->assertEquals($product->getPrice(), $product->getDiscountedPrice($offer));
    }

    public function test_product_discounted_price_with_full_discount(): void
    {
        $product = $this->getProductFloorplan();
        $offer = $this->getOfferFullDiscount();

        $this->assertEquals(0, $product->getDiscountedPrice($offer));
    }

    public function test_applying_a_valid_offer_to_empty_basket_gives_total_of_zero(): void
    {
        $this->assertEquals(0, $this->basket->getTotal());

        $this->basket->applyOffer($this->getOfferNoDiscount());

        $this->assertEquals(0, $this->basket->getTotal());
    }

    public function test_applying_a_valid_offer_with_discount_out_of_bounds_min_throws_exception(): void
    {
        $this->expectException(OfferDiscountOutOfBoundsException::class);

        try {
            $this->basket->applyOffer($this->getOfferOutOfBoundsMinDiscount());
        } catch (OfferDiscountOutOfBoundsException $e) {
            throw $e;
        }
    }

    public function test_applying_a_valid_offer_with_discount_out_of_bounds_max_throws_exception(): void
    {
        $this->expectException(OfferDiscountOutOfBoundsException::class);

        try {
           $this->basket->applyOffer($this->getOfferOutOfBoundsMaxDiscount());
        } catch (OfferDiscountOutOfBoundsException $e) {
            throw $e;
        }
    }

    public function test_adding_item_with_negative_amount_throws_exception(): void
    {
        $this->expectException(ProductPriceOutOfBoundsException::class);

        $this->basket->add($this->getProductFreeMoney());
        $this->assertEquals(0, $this->basket->getTotal());
    }

    public function test_adding_a_product_to_basket(): void
    {
        $this->basket->add($this->getProductPhotography());
        $this->assertCount(1, $this->basket->getItems());

        $total = $this->basket->getTotal();
        $this->assertEquals(20000, $total);
        $this->assertEquals('£200.00', $this->basket->getTotalFormatted($total));
    }

    public function test_adding_a_product_is_only_added_once(): void
    {
        $this->basket->add($this->getProductPhotography());
        $this->assertCount(1, $this->basket->getItems());

        $this->basket->add($this->getProductPhotography());
        $this->assertCount(1, $this->basket->getItems());
    }

    public function test_adding_multiple_products_total_is_calculated_correctly(): void
    {
        $this->basket->add($this->getProductPhotography());
        $this->basket->add($this->getProductFloorplan());

        $this->assertCount(2, $this->basket->getItems());
        $this->assertEquals(30000, $this->basket->getTotal());
    }

    public function test_single_product_with_offer_with_zero_discount(): void
    {
        $this->basket->add($this->getProductPhotography());
        $this->basket->applyOffer($this->getOfferNoDiscount());

        $this->assertCount(1, $this->basket->getItems());
        $this->assertEquals(20000, $this->basket->getTotal());
    }

    public function test_single_product_with_offer_with_non_zero_integer_discount(): void
    {
        $this->basket->add($this->getProductPhotography());
        $this->basket->applyOffer($this->getOfferTwelveMonthContractTenPercentDiscount());

        $this->assertCount(1, $this->basket->getItems());
        $this->assertEquals(18000, $this->basket->getTotal());
    }

    public function test_single_product_with_minor_units_with_offer_with_non_zero_integer_discount(): void
    {
        $this->basket->add($this->getProductGasCertificate());
        $this->basket->applyOffer($this->getOfferTwelveMonthContractTenPercentDiscount());

        $this->assertCount(1, $this->basket->getItems());

        // 83.50 / 10 = 8.35
        // 83.50 - 8.35 = 75.15
        $this->assertEquals(7515, $this->basket->getTotal());
    }

    public function test_multiple_products_with_minor_units_with_offer_with_non_zero_integer_discount(): void
    {
        $this->basket->add($this->getProductGasCertificate());
        $this->basket->add($this->getProductEicrCertificate());
        $this->basket->applyOffer($this->getOfferTwelveMonthContractTenPercentDiscount());

        $this->assertCount(2, $this->basket->getItems());

        // 83.50 / 10 = 8.35
        // 83.50 - 8.35 = 75.15

        // 51.00 / 10 = 5.10
        // 51 - 5.10 - 51 = 45.90
        // 4590 + 7315 = 121.05
        $this->assertEquals(12105, $this->basket->getTotal());
    }

    public function test_multiple_items_with_full_discount()
    {
        $this->basket->add($this->getProductGasCertificate());
        $this->basket->add($this->getProductEicrCertificate());
        $this->basket->applyOffer($this->getOfferFullDiscount());

        $this->assertCount(2, $this->basket->getItems());
        $this->assertEquals(0, $this->basket->getTotal());
    }

    public function test_single_low_value_item_with_discount_does_not_get_rounded_to_zero()
    {
        $this->basket->add($this->getProductJustAPenny());
        $this->basket->applyOffer($this->getOfferMajorityDiscount());

        $this->assertCount(1, $this->basket->getItems());
        $this->assertEquals(1, $this->basket->getTotal());
    }

    public function test_removing_an_item_when_basket_is_empty(): void
    {
        $this->assertCount(0, $this->basket->getItems());

        $this->basket->remove($this->getProductGasCertificate());

        $this->assertCount(0, $this->basket->getItems());
    }

    public function test_removing_an_item_when_item_is_in_basket(): void
    {
        $this->assertCount(0, $this->basket->getItems());

        $this->basket->add($this->getProductGasCertificate());

        $this->assertCount(1, $this->basket->getItems());

        $this->basket->remove($this->getProductGasCertificate());

        $this->assertCount(0, $this->basket->getItems());
    }

    public function test_item_exists_in_basket()
    {
        $product = $this->getProductEicrCertificate();
        $this->basket->add($product);

        $this->assertTrue($this->basket->getItems()->offsetExists($product->getId()));
    }
}
