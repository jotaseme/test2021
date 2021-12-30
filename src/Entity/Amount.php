<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Embeddable()
 */
class Amount
{
    /**
     * @ORM\Column(name="value", type="decimal", precision=14, scale=4)
     */
    private float $value;

    /**
     * @ORM\Column(name="currency", type="string", length=3)
     */
    private string $currency;

    public function getValue(): ?float
    {
        return $this->value;
    }

    public function setValue(float $value): self
    {
        $this->value = $value;

        return $this;
    }

    public function getCurrency(): ?string
    {
        return $this->currency;
    }

    public function setCurrency(string $currency): self
    {
        $this->currency = $currency;

        return $this;
    }
}
