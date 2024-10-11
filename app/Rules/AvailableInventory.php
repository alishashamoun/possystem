<?php

namespace App\Rules;

use App\Models\Inventory;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class AvailableInventory implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        //
    }


    protected $productId;

    /**
     * Create a new rule instance.
     *
     * @param  int  $productId
     * @return void
     */
    public function __construct($productId)
    {
        $this->productId = $productId;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        // Get the inventory record for the given product ID
        $inventory = Inventory::where('product_id', $this->productId)->first();

        if (!$inventory) {
            return false; // Product not found in inventory
        }

        // Check if the requested quantity is available
        return $inventory->quantity >= $value;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The requested quantity exceeds the available stock in inventory.';
    }
}
