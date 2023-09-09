<?php

namespace AS2\Tests;

use AS2\Management;
use AS2\MessageRepositoryInterface;
use AS2\PartnerRepositoryInterface;
use AS2\Tests\Mock\MessageRepository;
use AS2\Tests\Mock\PartnerRepository;

abstract class TestCase extends \PHPUnit\Framework\TestCase
{
    /**
     * @var Management
     */
    protected $management;

    /**
     * @var PartnerRepositoryInterface
     */
    protected $partnerRepository;

    /**
     * @var MessageRepositoryInterface
     */
    protected $messageRepository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->partnerRepository = new PartnerRepository();
        $this->messageRepository = new MessageRepository();
        $this->management = new Management();
    }

    protected function loadFixture($name)
    {
        return file_get_contents(__DIR__.\DIRECTORY_SEPARATOR.'fixtures'.\DIRECTORY_SEPARATOR.$name);
    }

    protected function getCerts($file = 'phpas2.p12')
    {
        $certs = [];
        $pkcs12 = $this->loadFixture($file);
        openssl_pkcs12_read($pkcs12, $certs, '');

        return $certs;
    }

    protected function initMessage($file = 'test.edi')
    {
        $body = $this->loadFixture($file);

        return "Content-type: application/EDI-Consent\r\nContent-Transfer-Encoding: binary\r\nContent-Disposition: attachment; filename=payload.txt\r\n\r\n{$body}";
        // return new MimePart(
        //     [
        //         'Content-type' => 'application/EDI-Consent',
        //         'Content-Transfer-Encoding' => 'binary',
        //         'Content-Disposition' => 'attachment; filename=payload.txt',
        //     ], $this->loadFixture($file)
        // );
    }
}
