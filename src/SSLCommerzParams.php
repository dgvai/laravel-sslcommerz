<?php 
namespace DGvai\SSLCommerz;

use DGvai\SSLCommerz\SSLCommerzParamVars;

class SSLCommerzParams extends SSLCommerzParamVars
{
    public function amount($amount)
    {
        $this->total_amount = $amount;
        return $this;
    }

    public function trxid($trxid = null)
    {
        $this->tran_id = is_null($trxid) ? uniqid() : $trxid;
        return $this;
    }

    public function product(string $name, $category = 'online')
    {
        $this->product_name = $name;
        $this->product_category = $category;
        return $this;
    }

    public function customer(string $name, string $email, $phone = ' ', $address = ' ', $city = ' ', $state = null, $postal = null, $country = 'Bangladesh', $fax = null)
    {
        $this->cus_name = $name;
        $this->cus_email = $email;
        $this->cus_phone = is_null($phone) ? ' ' : $phone;
        $this->cus_add1 = is_null($address) ? ' ' : $address;
        $this->cus_add2 = $address;
        $this->cus_city = is_null($city) ? ' ' : $city;
        $this->cus_state = $state;
        $this->cus_postcode = is_null($postal) ? ' ' : $postal;
        $this->cus_country = is_null($country) ? ' ' : $country;
        $this->cus_fax = $fax;
        return $this;
    }

    public function setUrl(array $url_array)
    {
        $this->success_url = $url_array[0];
        $this->fail_url = $url_array[1];
        $this->cancel_url = $url_array[2];
        $this->ipn_url = $url_array[3];

        return $this;
    }

    public function setCurrency($currency)
    {
        $this->currency = $currency;
        return $this;
    }

    public function setBin(string $BIN)
    {
        $this->allowed_bin = $BIN;
        return $this;
    }

    public function enableEMI(int $installment, int $max_installment, bool $restrict_emi_only = false)
    {
        $this->emi_option = 1;
        $this->emi_selected_inst = $installment;
        $this->emi_max_inst_option = $max_installment;
        $this->emi_allow_only = $restrict_emi_only ? 1 : 0;
        return $this;
    }

    public function setShipping(int $product_number, string $name, string $address, string $city, $postal = null, $state = null, $country = null)
    {
        $this->shipping_method = 'YES';
        $this->num_of_item = $product_number;
        $this->ship_name = $name;
        $this->ship_add1 = $address;
        $this->ship_add2 = $address;
        $this->ship_city = $city;
        $this->ship_state = $postal;
        $this->ship_postcode = $state;
        $this->ship_country = $country;
        return $this;   
    }

    public function setAirlineTicketProfile($flight_type, $hours_till_departure, $pnr, $journey_from_to, $third_party_booking)
    {
        $this->product_profile = 'airline-tickets';
        $this->hours_till_departure = $hours_till_departure;
        $this->flight_type = $flight_type;
        $this->pnr = $pnr;
        $this->journey_from_to = $journey_from_to;
        $this->third_party_booking = $third_party_booking;
        return $this;
    }

    public function setTravelVerticalProfile($hotel_name, $length_of_stay, $check_in_time, $hotel_city)
    {
        $this->product_profile = 'travel-vertical';
        $this->hotel_name = $hotel_name;
        $this->length_of_stay = $length_of_stay;
        $this->check_in_time = $check_in_time;
        $this->hotel_city = $hotel_city;
        return $this;
    }

    public function setTelecomVerticleProfile($product_type, $topup_number, $country_topup)
    {
        $this->product_profile = 'telecom-vertical';
        $this->product_type = $product_type;
        $this->topup_number = $topup_number;
        $this->country_topup = $country_topup;
        return $this;
    }

    public function setCarts($cart, $product_amount, $vat, $discount_amount, $convenience_fee)
    {
        $this->cart = $cart;
        $this->product_amount = $product_amount;
        $this->vat = $vat;
        $this->discount_amount = $discount_amount;
        $this->convenience_fee = $convenience_fee;
        return $this;
    }

    public function setExtras($extra1 = null, $extra2 = null, $extra3 = null, $extra4 = null)
    {
        $this->value_a = $extra1;
        $this->value_b = $extra2;
        $this->value_c = $extra3;
        $this->value_d = $extra4;
        return $this;
    }

    protected function __initialize_defaults()
    {
        $this->allowed_bin = null;
        $this->emi_option = 0;
        $this->emi_max_inst_option = null;
        $this->emi_selected_inst = null;
        $this->emi_allow_only = null;
        $this->shipping_method = 'NO';
        $this->num_of_item = 1;
        $this->ship_name = null;
        $this->ship_add1 = null;
        $this->ship_add2 = null;
        $this->ship_city = null;
        $this->ship_state = null;
        $this->ship_postcode = null;
        $this->ship_country = null;
        $this->hours_till_departure = null;
        $this->flight_type = null;
        $this->pnr = null;
        $this->journey_from_to = null;
        $this->third_party_booking = null;
        $this->hotel_name = null;
        $this->length_of_stay = null;
        $this->check_in_time = null;
        $this->hotel_city = null;
        $this->product_type = null;
        $this->topup_number = null;
        $this->country_topup = null;
        $this->cart = null;
        $this->product_amount = null;
        $this->vat = null;
        $this->discount_amount = null;
        $this->convenience_fee = null;
        $this->value_a = null;
        $this->value_b = null;
        $this->value_c = null;
        $this->value_d = null;
    }
}