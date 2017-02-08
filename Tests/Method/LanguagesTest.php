<?php

namespace Eko\GoogleTranslateBundle\Tests\Method;

use Eko\GoogleTranslateBundle\Translate\Method\Languages;

/**
 * Languages class test.
 *
 * @author Vincent Composieux <vincent.composieux@gmail.com>
 */
class LanguagesTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Languages Languages service
     */
    protected $languages;

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
        $this->languages = $this->getMock(
            'Eko\GoogleTranslateBundle\Translate\Method\Languages',
            null,
            ['fakeapikey', $this->clientMock]
        );
    }

    /**
     * Test simple get method.
     */
    public function testSimpleGet()
    {
        // Given
        $this
            ->clientMock
            ->expects($this->any())
            ->method('getJson')
            ->willReturn(
                ['data' => ['languages' => [['language' => 'en'], ['language' => 'fr']]]]
            )
        ;

        // When
        $values = $this->languages->get();

        // Then
        $this->assertCount(2, $values, 'Should return 2 values');

        foreach ($values as $value) {
            $this->assertArrayHasKey('language', $value, 'Should have an array key "language"');
            $this->assertTrue(in_array($value['language'], ['fr', 'en'], 'Language should be "fr" or "en"'));
        }
    }

    /**
     * Test get method with a target parameter.
     */
    public function testGetWithTarget()
    {
        // Given
        $this
            ->clientMock
            ->expects($this->any())
            ->method('getJson')
            ->willReturn(
                ['data' => ['languages' => [
                    ['language' => 'en', 'name' => 'Anglais'],
                    ['language' => 'fr', 'name' => 'Français'],
                ]]]
            )
        ;

        // When
        $values = $this->languages->get('fr');

        // Then
        $this->assertCount(2, $values, 'Should return 2 values');

        foreach ($values as $value) {
            $this->assertArrayHasKey('language', $value, 'Should have an array key "language"');
            $this->assertArrayHasKey('name', $value, 'Should have an array key "name"');

            $this->assertTrue(in_array($value['language'], ['fr', 'en'], 'Language should be "fr" or "en"'));
            $this->assertTrue(in_array($value['name'], ['Français', 'Anglais'], 'Language should be "Français" or "Anglais"'));
        }
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
