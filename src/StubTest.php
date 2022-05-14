<?php

use PHPUnit\Framework\TestCase;

class A
{
    public function funcA()
    {
    }
}

class StubTest extends TestCase
{
    public function testStub(): void
    {
        /** @var \A&\PHPUnit\Framework\MockObject\Builder\InvocationMocker */
        $stub = $this->createStub(A::class);
        $stub->method("funcA")->willReturn("a");
        $this->assertEquals("a", $stub->funcA());

        /** @var \A&\PHPUnit\Framework\MockObject\Builder\InvocationMocker */
        $stub = $this->createStub(A::class);
        $stub->method("funcA")->willReturnArgument(1);
        $this->assertEquals("b", $stub->funcA("a", "b"));

        /** @var \A&\PHPUnit\Framework\MockObject\Builder\InvocationMocker */
        $stub = $this->createStub(A::class);
        $stub->method("funcA")->willReturnCallback(fn (string $a, string $b) => $a . $b);
        $this->assertEquals("ab", $stub->funcA("a", "b"));

        /** @var \A&\PHPUnit\Framework\MockObject\Builder\InvocationMocker */
        $stub = $this->createStub(A::class);
        $stub->method("funcA")->willReturnMap([
            ["a", "return_a"],
            ["b", "c", "return_bc"],
        ]);
        $this->assertEquals("return_a", $stub->funcA("a"));
        $this->assertEquals("return_bc", $stub->funcA("b", "c"));

        /** @var \A&\PHPUnit\Framework\MockObject\Builder\InvocationMocker */
        $stub = $this->createStub(A::class);
        $stub->method("funcA")->willReturnOnConsecutiveCalls("a", "b", "c");
        $this->assertEquals("a", $stub->funcA());
        $this->assertEquals("b", $stub->funcA());
        $this->assertEquals("c", $stub->funcA());
        $this->assertEquals(null, $stub->funcA());

        /** @var \A&\PHPUnit\Framework\MockObject\Builder\InvocationMocker */
        $stub = $this->createStub(A::class);
        $stub->method("funcA")->willReturnSelf();

        /** @var \A&\PHPUnit\Framework\MockObject\Builder\InvocationMocker */
        $stub = $this->createStub(A::class);
        $stub->method("funcA")->willThrowException(new Exception("a"));
        $this->expectExceptionMessage("a");
        $stub->funcA();
    }
}
