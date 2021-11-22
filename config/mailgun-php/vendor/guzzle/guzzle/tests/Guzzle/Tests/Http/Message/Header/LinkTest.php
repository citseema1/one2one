<?php

namespace Guzzle\Tests\Http\Message\Header;

use Guzzle\Http\Message\Header\Link;
use Guzzle\Tests\GuzzleTestCase;

class LinkTest extends GuzzleTestCase
{
    public function testParsesLinks()
    {
        $link = new Link('Link', '<https:/.../front.jpeg>; rel=front; type="image/jpeg", <https://.../back.jpeg>; rel=back; type="image/jpeg", <https://.../side.jpeg?test=1>; rel=side; type="image/jpeg"');
        $links = $link->getLinks();
        $this->assertEquals(array(
            array(
                'rel' => 'front',
                'type' => 'image/jpeg',
                'url' => 'https:/.../front.jpeg',
            ),
            array(
                'rel' => 'back',
                'type' => 'image/jpeg',
                'url' => 'https://.../back.jpeg',
            ),
            array(
                'rel' => 'side',
                'type' => 'image/jpeg',
                'url' => 'https://.../side.jpeg?test=1'
            )
        ), $links);

        $this->assertEquals(array(
            'rel' => 'back',
            'type' => 'image/jpeg',
            'url' => 'https://.../back.jpeg',
        ), $link->getLink('back'));

        $this->assertTrue($link->hasLink('front'));
        $this->assertFalse($link->hasLink('foo'));
    }

    public function testCanAddLink()
    {
        $link = new Link('Link', '<https://foo>; rel=a; type="image/jpeg"');
        $link->addLink('https://test.com', 'test', array('foo' => 'bar'));
        $this->assertEquals(
            '<https://foo>; rel=a; type="image/jpeg", <https://test.com>; rel="test"; foo="bar"',
            (string) $link
        );
    }

    public function testCanParseLinksWithCommas()
    {
        $link = new Link('Link', '<https://example.com/TheBook/chapter1>; rel="previous"; title="start, index"');
        $this->assertEquals(array(
            array(
                'rel' => 'previous',
                'title' => 'start, index',
                'url' => 'https://example.com/TheBook/chapter1',
            )
        ), $link->getLinks());
    }
}
