<?php

declare(strict_types=1);

namespace App\Tests\unit\App\Domain\Entity\ValueObject;

use App\Domain\Entity\ValueObject\Email;
use Codeception\Test\Unit;

class EmailTest extends Unit
{
    /**
     * @param $email
     * @dataProvider correctValueDataProvider
     */
    public function testCorrectValueShouldNotRaiseException($email): void
    {
        new Email($email);
    }

    /**
     * @param $email
     * @dataProvider incorrectValueDataProvider
     */
    public function testIncorrectValueShouldRaiseException($email): void
    {
        $this->expectException(\DomainException::class);

        new Email($email);
    }

    public function testEmailToStringShouldReturnValue(): void
    {
        $email = new Email('niceandsimple@example.com');

        $this->assertEquals('niceandsimple@example.com', (string)$email);
    }

    public function correctValueDataProvider(): array
    {
        return [
            ['niceandsimple@example.com'],
            ['very.common@example.com'],
            ['a.little.lengthy.but.fine@dept.example.com'],
            ['disposable.style.email.with+symbol@example.com'],
            ['user@[IPv6:2001:db8:1ff::a0b:dbd0]']
        ];
    }

    public function incorrectValueDataProvider(): array
    {
        return [
            ['Abc.example.com'],
            ['A@b@c@example.com'],
            ['a"b(c)d,e:f;gi[j\k]l@example.com'],
            ['just"not"right@example.com'],
            ['this is"not\allowed@example.com'],
            ['this\ still\"not\allowed@example.com'],
        ];
    }
}
