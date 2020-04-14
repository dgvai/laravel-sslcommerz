<?php 
namespace DGvai\SSLCommerz;

class SSLCommerzParamVars 
{
    public $store_id;
    public $store_passwd;
    public $total_amount;
    public $currency;
    public $tran_id;

    public $success_url;
    public $fail_url;
    public $cancel_url;
    public $ipn_url;

    public $multi_card_name;
    public $allowed_bin;

    public $emi_option;
    public $emi_max_inst_option;
    public $emi_selected_inst;
    public $emi_allow_only;

    public $cus_name;
    public $cus_email;
    public $cus_add1;
    public $cus_add2;
    public $cus_city;
    public $cus_state;
    public $cus_postcode;
    public $cus_country;
    public $cus_phone;
    public $cus_fax;

    public $shipping_method;
    public $num_of_item;
    public $ship_name;
    public $ship_add1;
    public $ship_add2;
    public $ship_city;
    public $ship_state;
    public $ship_postcode;
    public $ship_country;

    public $product_name;
    public $product_category;
    public $product_profile;

    public $hours_till_departure;
    public $flight_type;
    public $pnr;
    public $journey_from_to;
    public $third_party_booking;

    public $hotel_name;
    public $length_of_stay;
    public $check_in_time;
    public $hotel_city;

    public $product_type;
    public $topup_number;
    public $country_topup;

    public $cart;
    public $product_amount;
    public $vat;
    public $discount_amount;
    public $convenience_fee;

    public $value_a;
    public $value_b;
    public $value_c;
    public $value_d;

    public function makeBody()
    {
        $body['store_id'] = $this->store_id;
        $body['store_passwd'] = $this->store_passwd;
        $body['total_amount'] = $this->total_amount;
        $body['currency'] = $this->currency;
        $body['tran_id'] = $this->tran_id;

        $body['success_url'] = $this->success_url;
        $body['fail_url'] = $this->fail_url;
        $body['cancel_url'] = $this->cancel_url;
        $body['ipn_url'] = $this->ipn_url;

        $body['multi_card_name'] = $this->multi_card_name;
        $body['allowed_bin'] = $this->allowed_bin;

        $body['emi_option'] = $this->emi_option;
        $body['emi_max_inst_option'] = $this->emi_max_inst_option;
        $body['emi_selected_inst'] = $this->emi_selected_inst;
        $body['emi_allow_only'] = $this->emi_allow_only;

        $body['cus_name'] = $this->cus_name;
        $body['cus_email'] = $this->cus_email;
        $body['cus_add1'] = $this->cus_add1;
        $body['cus_add2'] = $this->cus_add2;
        $body['cus_city'] = $this->cus_city;
        $body['cus_state'] = $this->cus_state;
        $body['cus_postcode'] = $this->cus_postcode;
        $body['cus_country'] = $this->cus_country;
        $body['cus_phone'] = $this->cus_phone;
        $body['cus_fax'] = $this->cus_fax;

        $body['shipping_method'] = $this->shipping_method;
        $body['num_of_item'] = $this->num_of_item;
        $body['ship_name'] = $this->ship_name;
        $body['ship_add1'] = $this->ship_add1;
        $body['ship_add2'] = $this->ship_add2;
        $body['ship_city'] = $this->ship_city;
        $body['ship_state'] = $this->ship_state;
        $body['ship_postcode'] = $this->ship_postcode;
        $body['ship_country'] = $this->ship_country;

        $body['product_name'] = $this->product_name;
        $body['product_category'] = $this->product_category;
        $body['product_profile'] = $this->product_profile;

        $body['hours_till_departure'] = $this->hours_till_departure;
        $body['flight_type'] = $this->flight_type;
        $body['pnr'] = $this->pnr;
        $body['journey_from_to'] = $this->journey_from_to;
        $body['third_party_booking'] = $this->third_party_booking;

        $body['hotel_name'] = $this->hotel_name;
        $body['length_of_stay'] = $this->length_of_stay;
        $body['check_in_time'] = $this->check_in_time;
        $body['hotel_city'] = $this->hotel_city;

        $body['product_type'] = $this->product_type;
        $body['topup_number'] = $this->topup_number;
        $body['country_topup'] = $this->country_topup;

        $body['cart'] = $this->cart;
        $body['product_amount'] = $this->product_amount;
        $body['vat'] = $this->vat;
        $body['discount_amount'] = $this->discount_amount;
        $body['convenience_fee'] = $this->convenience_fee;

        $body['value_a'] = $this->value_a;
        $body['value_b'] = $this->value_b;
        $body['value_c'] = $this->value_c;
        $body['value_d'] = $this->value_d;

        return $body;
    }
}