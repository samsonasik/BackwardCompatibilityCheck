<?php

declare(strict_types=1);

namespace RoaveTest\ApiCompare\DetectChanges\BCBreak\InterfaceBased;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Roave\ApiCompare\Change;
use Roave\ApiCompare\Changes;
use Roave\ApiCompare\DetectChanges\BCBreak\InterfaceBased\InterfaceBased;
use Roave\ApiCompare\DetectChanges\BCBreak\InterfaceBased\MultipleChecksOnAnInterface;
use Roave\BetterReflection\Reflection\ReflectionClass;

/**
 * @covers \Roave\ApiCompare\DetectChanges\BCBreak\InterfaceBased\MultipleChecksOnAnInterface
 */
final class MultipleChecksOnAnInterfaceTest extends TestCase
{
    public function testChecksAllGivenCheckers() : void
    {
        /** @var InterfaceBased|MockObject $checker1 */
        $checker1 = $this->createMock(InterfaceBased::class);
        /** @var InterfaceBased|MockObject $checker2 */
        $checker2 = $this->createMock(InterfaceBased::class);
        /** @var InterfaceBased|MockObject $checker3 */
        $checker3 = $this->createMock(InterfaceBased::class);

        $multiCheck = new MultipleChecksOnAnInterface($checker1, $checker2, $checker3);

        /** @var ReflectionClass|MockObject $from */
        $from = $this->createMock(ReflectionClass::class);
        /** @var ReflectionClass|MockObject $to */
        $to = $this->createMock(ReflectionClass::class);

        $checker1
            ->expects(self::once())
            ->method('__invoke')
            ->with($from, $to)
            ->willReturn(Changes::fromList(Change::added('1', true)));

        $checker2
            ->expects(self::once())
            ->method('__invoke')
            ->with($from, $to)
            ->willReturn(Changes::fromList(Change::added('2', true)));

        $checker3
            ->expects(self::once())
            ->method('__invoke')
            ->with($from, $to)
            ->willReturn(Changes::fromList(Change::added('3', true)));

        $this->assertEquals(
            Changes::fromList(
                Change::added('1', true),
                Change::added('2', true),
                Change::added('3', true)
            ),
            $multiCheck->__invoke($from, $to)
        );
    }
}
