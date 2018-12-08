<?php

use Illuminate\Database\Seeder;
use Pixney\WysiwygBlockExtension\Block\BlockModel;
use Anomaly\PagesModule\Page\Contract\PageRepositoryInterface;
use Anomaly\PagesModule\Type\Contract\TypeRepositoryInterface;
use Anomaly\BlocksModule\Block\Contract\BlockRepositoryInterface;
use Anomaly\Streams\Platform\Model\Pages\PagesDefaultPagesEntryModel;

class AboutSeeder extends Seeder
{
    /**
     * The page repository.
     *
     * @var PageRepositoryInterface
     */
    protected $pages;

    /**
     * The types repository.
     *
     * @var TypeRepositoryInterface
     */
    protected $types;

    /**
     * The types repository.
     *
     * @var BlockRepositoryInterface
     */
    protected $blocks;

    /**
     * Create a new PageSeeder instance.
     *
     * @param BlockRepositoryInterface $blocks
     * @param PageRepositoryInterface $pages
     * @param TypeRepositoryInterface $types
     */
    public function __construct(
        BlockRepositoryInterface $blocks,
        PageRepositoryInterface $pages,
        TypeRepositoryInterface $types
    ) {
        $this->pages  = $pages;
        $this->types  = $types;
        $this->blocks = $blocks;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $pageType = $this->types->findBySlug('default');

        $content = 'My content';

        $block = (new BlockModel())->create([
            'content' => $content,
        ]);

        $entry = (new PagesDefaultPagesEntryModel())->create();

        $page = $this->pages->create(
            [
                'en' => [
                    'title' => 'About page'
                ],
                'slug'         => str_slug('About page'),
                'entry'        => $entry,
                'type'         => $pageType,
                'enabled'      => true,
                'home'         => false,
                'theme_layout' => 'theme::layouts/default.twig',
            ]
        );

        $page->allowedRoles()->sync([]);

        $this->blocks->create(
            [
                'area'       => $entry,
                'entry'      => $block,
                'field'      => $pageType->getEntryStream()->getField('content_blocks'),
                'extension'  => 'pixney.extension.wysiwyg_block',
                'sort_order' => 1,
            ]
        );
        $this->command->info('Page and blocks for it seeded.');
    }
}
