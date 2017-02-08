<?php

namespace Eko\GoogleTranslateBundle\Tests\Method;

use Eko\GoogleTranslateBundle\Translate\Method\Detector;

/**
 * Detector class test.
 *
 * @author Vincent Composieux <vincent.composieux@gmail.com>
 */
class DetectorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Detector Detector service
     */
    protected $detector;

    /**
     * @var \Eko\GoogleTranslateBundle\Http\ClientInterface mock
     */
    protected $clientMock;

    /**
     * Set up methods services.
     */
    protected function setUp()
    {
        $this->clientMock = $this->getClientMock();
        $this->detector = $this->getMock(
            'Eko\GoogleTranslateBundle\Translate\Method\Detector',
            null,
            ['fakeapikey', $this->clientMock]
        );
    }

    /**
     * Test simple detect method.
     */
    public function testSimpleDetect()
    {
        // Given
        $this
            ->clientMock
            ->expects($this->any())
            ->method('getJson')
            ->willReturn(
                ['data' => ['detections' => [[['language' => 'en']]]]]
            )
        ;

        // When
        $language = $this->detector->detect('hi');

        // Then
        $this->assertEquals($language, 'en', 'Should return language "en"');
    }

    /**
     * Test exception detect method.
     */
    public function testExceptionDetect()
    {
        $this
            ->clientMock
            ->expects($this->any())
            ->method('getJson')
            ->willReturn(
                ['data' => ['detections' => [[['language' => Detector::UNDEFINED_LANGUAGE]]]]]
            )
        ;

        $this->setExpectedException('Eko\GoogleTranslateBundle\Exception\UnableToDetectException');

        $this->detector->detect('undefined');
    }

    /**
     * Returns Guzzle HTTP client mock and sets response mock property.
     *
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    protected function getClientMock()
    {
        $clientMock = $this->getMockBuilder('Eko\GoogleTranslateBundle\Http\ClientInterface')
            ->disableOriginalConstructor()
            ->getMock();

        return $clientMock;
    }
}
