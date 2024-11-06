<?php

namespace App\Tests;

use Psr\Log\LoggerInterface;
use App\Utils\Test\TestMessageError;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase as sfKernelTestCase;

abstract class KernelTestCase extends sfKernelTestCase {
  const PREFIX_GIVEN = "[ETANT DONNE]";
  private $_iteration_number=0;
  private $_sub_iteration_number=0;

  public function setUp(): void {
  }

  public function compareTo(mixed $value,mixed $valueReferred,string $msgOnSuccess,string $msgOnFailed): bool {
    if(is_array($value))
      $value = serialize($value);
    if(is_array($valueReferred))
      $valueReferred = serialize($valueReferred);
    if(null !== $value) {
      $msgOnSuccess = str_replace("{value}",$value,$msgOnSuccess);
      $msgOnFailed = str_replace("{value}",$value,$msgOnFailed);
    }
    if(null !== $valueReferred) {
      $msgOnSuccess = str_replace("{valueReferred}",$valueReferred,$msgOnSuccess);
      $msgOnFailed = str_replace("{valueReferred}",$valueReferred,$msgOnFailed);
    }
    if($value === $valueReferred) {
      $this->success($msgOnSuccess);
      $this->assertTrue(true);
      return true;
    }
    else {
      $this->error($msgOnFailed);
      $this->assertTrue(false);
      return false;
    }
  }

  public function error(string $text): void {
    fwrite(STDERR,"\r\n\e[1m\e[31m ✘ $text\e[0m\r\n");
  }

  public function success(string $text): void {
    fwrite(STDERR,"\r\n\e[1m\e[32m ✔ $text\e[0m\r\n");
  }

  public function section(string $text): void {
    $len = mb_strlen($text);
    fwrite(STDERR, "\r\n$text\r\n");
    fwrite(STDERR, str_repeat("-",$len)."\r\n");
    $this->_iteration_number=0;
    $this->_sub_iteration_number=0;
  }

  public function given(string $description, ...$args): TestGiven {
    $this->iteration(self::PREFIX_GIVEN.' '.$description);
    return new TestGiven($this,$args);
  }

  public function subiteration(string $text): void {
    $this->_sub_iteration_number++;
    $iteration = $this->_iteration_number;
    $subiteration = $this->_sub_iteration_number;
    fwrite(STDERR, "\r\n$iteration.$subiteration. $text\r\n");
  }

  public function iteration(string $text): void {
    $this->_iteration_number++;
    $iteration = $this->_iteration_number;
    fwrite(STDERR, "\r\n$iteration. $text\r\n");
    $this->_sub_iteration_number=0;
  }

  public function debug($data): void {
    fwrite(STDERR, "\r\n");
    fwrite(STDERR, print_r($data, true));
    fwrite(STDERR, "\r\n\r\n");
  }
}
