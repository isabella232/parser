<?php declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: jeroen
 * Date: 10-8-18
 * Time: 13:02
 */

namespace Elgentos\Parser\Stories\Reader;

use Elgentos\Parser\Context;
use Elgentos\Parser\Exceptions\RuleInvalidContextException;
use Elgentos\Parser\Story;
use Elgentos\Parser\StoryMetrics;
use PHPUnit\Framework\TestCase;

class ComplextTest extends TestCase
{
    public function testGetStory()
    {
        $reader = new Complex(PARSERTEST_DATA_DIR);
        $this->assertInstanceOf(Story::class, $reader->getStory());
    }

    public function testGetMetrics()
    {
        $reader = new Complex(PARSERTEST_DATA_DIR);
        $this->assertInstanceOf(StoryMetrics::class, $reader->getMetrics());
    }

    public function test__construct()
    {
        $readerMock = $this->getMockBuilder(Complex::class)
                ->setMethods(['initStory'])
                ->getMock();

        $readerMock->expects($this->exactly(2))
                ->method('initStory')
                ->withConsecutive(['.'], ['./']);

        $readerMock->__construct();
        $readerMock->__construct('./');
    }

    public function testInvalidFile()
    {
        $reader = new Complex(PARSERTEST_DATA_DIR);

        $data = [
                '@import' => 'base.yml'
        ];

        $this->expectException(RuleInvalidContextException::class);

        $context = new Context($data);

        $reader->getStory()
                ->parse($context);
    }

    public function testIntegration()
    {
        $reader = new Complex(PARSERTEST_DATA_DIR);

        $data = [
            '@import' => 'base.yaml'
        ];

        $result = [
            'base' => [
                ['context' => 'YAML'],
                [
                    'json' => [
                        ['context' => 'JSON'],
                        [
                            ['@import' => 'CSV'],
                            ['text' => 'This is a TEXT'],
                            ['xml' => ['config' => 'test']]
                        ]
                    ]
                ],
                [
                    'xml' => ['config' => 'test']
                ],
                [
                        'This is a TEXT',
                        'TEXT1',
                        'TEXT2',
                        'TEXT3',
                        'TEXT4',
                ],
                [
                    'globtext' => [
                        ['text' => 'TEXT1'],
                        ['text' => 'TEXT2'],
                    ]
                ]
            ],
            'second' => ['text' => 'TEXT1'],
            'csv' => [
                    [
                            ['column1' => '1', 'column2' => '1']
                    ],
                    [
                            ['column1' => '2', 'column2' => '2'],
                            ['column1' => '3', 'column2' => '3'],
                            ['column1' => '"quote', 'column2' => 'test'],
                            ['column1' => '"', 'column2' => "'"]
                    ],
            ],
            'csvdir' => [
                    ['column1' => '1', 'column2' => '1'],
                    ['column1' => '2', 'column2' => '2'],
                    ['column1' => '3', 'column2' => '3'],
                    ['column1' => '"quote', 'column2' => 'test'],
                    ['column1' => '"', 'column2' => "'"]
            ],
        ];

        $context = new Context($data);

        $reader->getStory()
                ->parse($context);

        $this->assertSame($result, $data);
    }
}
