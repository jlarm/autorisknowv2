<?php

use Illuminate\Database\Eloquent\Model;
use App\Services\SeoService;
use Livewire\Component;

new class extends Component {
    public Model $model;

    public ?string $contentField = 'content';

    public string $metaTitle = '';

    public string $metaDescription = '';

    public array $keywords = [];

    public string $newKeyword = '';

    public array $titleSuggestions = [];

    public array $descriptionSuggestions = [];

    public ?array $seoAnalysis = null;

    public bool $isGeneratingTitle = false;

    public bool $isGeneratingDescription = false;

    public bool $isAnalyzing = false;

    protected $listeners = ['save-seo' => 'saveQuietly'];

    public function mount(): void
    {
        if ($this->model->seo) {
            $this->metaTitle = $this->model->seo->meta_title ?? '';
            $this->metaDescription = $this->model->seo->meta_description ?? '';
            $this->keywords = $this->model->seo->keywords ?? [];
        }
    }

    protected function getModelContent(): string
    {
        if ($this->contentField === null) {
            return '';
        }

        if (!property_exists($this->model, $this->contentField) && !method_exists($this->model, '__get')) {
            return '';
        }

        return $this->model->{$this->contentField} ?? '';
    }

    public function generateMetaDescription(SeoService $seoService): void
    {
        if (!config('services.anthropic.api_key')) {
            $this->addError('metaDescription', 'Anthropic API key not configured. Please add ANTHROPIC_API_KEY to your .env file.');

            return;
        }

        $this->isGeneratingDescription = true;

        try {
            $result = $seoService->generateMetaDescription([
                'title' => $this->model->title,
                'content' => $this->getModelContent(),
            ]);

            $this->metaDescription = $result['description'];
            $this->descriptionSuggestions = $result['alternatives'];
        } catch (Exception $e) {
            $this->addError('metaDescription', 'Failed to generate meta description: ' . $e->getMessage());
        } finally {
            $this->isGeneratingDescription = false;
        }
    }

    public function generateSeoTitle(SeoService $seoService): void
    {
        if (!config('services.anthropic.api_key')) {
            $this->addError('metaTitle', 'Anthropic API key not configured. Please add ANTHROPIC_API_KEY to your .env file.');

            return;
        }

        $this->isGeneratingTitle = true;

        try {
            $result = $seoService->generateSeoTitle([
                'title' => $this->model->title,
                'content' => $this->getModelContent(),
            ]);

            $this->metaTitle = $result['title'];
            $this->titleSuggestions = $result['alternatives'];
        } catch (Exception $e) {
            $this->addError('metaTitle', 'Failed to generate SEO title: ' . $e->getMessage());
        } finally {
            $this->isGeneratingTitle = false;
        }
    }

    public function analyzeSeo(SeoService $seoService): void
    {
        if (!config('services.anthropic.api_key')) {
            $this->addError('seoAnalysis', 'Anthropic API key not configured. Please add ANTHROPIC_API_KEY to your .env file.');

            return;
        }

        $this->isAnalyzing = true;

        try {
            $this->seoAnalysis = $seoService->analyzeContent([
                'title' => $this->model->title,
                'content' => $this->getModelContent(),
                'metaTitle' => $this->metaTitle,
                'metaDescription' => $this->metaDescription,
            ]);
        } catch (Exception $e) {
            $this->addError('seoAnalysis', 'Failed to analyze SEO: ' . $e->getMessage());
        } finally {
            $this->isAnalyzing = false;
        }
    }

    public function useTitleSuggestion(string $suggestion): void
    {
        $this->metaTitle = $suggestion;
        $this->titleSuggestions = [];
    }

    public function useDescriptionSuggestion(string $suggestion): void
    {
        $this->metaDescription = $suggestion;
        $this->descriptionSuggestions = [];
    }

    public function addKeyword(string $keyword): void
    {
        $keyword = trim($keyword);

        if ($keyword !== '' && !in_array($keyword, $this->keywords)) {
            $this->keywords[] = $keyword;
        }
    }

    public function addNewKeyword(): void
    {
        if ($this->newKeyword !== '') {
            $this->addKeyword($this->newKeyword);
            $this->newKeyword = '';
        }
    }

    public function removeKeyword(int $index): void
    {
        unset($this->keywords[$index]);
        $this->keywords = array_values($this->keywords);
    }

    public function saveQuietly(): void
    {
        $this->model->seo()->updateOrCreate(
            ['seoable_id' => $this->model->id, 'seoable_type' => get_class($this->model)],
            [
                'meta_title' => $this->metaTitle,
                'meta_description' => $this->metaDescription,
                'keywords' => $this->keywords,
            ],
        );

        $this->dispatch('seo-saved');
    }

    public function save(): void
    {
        $this->saveQuietly();

        Flux::toast(variant: 'success', text: 'SEO updated successfully');
    }

    public function updated($property): void
    {
        if (in_array($property, ['metaTitle', 'metaDescription', 'keywords'])) {
            $this->titleSuggestions = [];
            $this->descriptionSuggestions = [];
            $this->seoAnalysis = null;
        }
    }
};
?>

<div class="space-y-6">
    <flux:heading size="lg">SEO Settings</flux:heading>

    <flux:field>
        <div class="flex items-center justify-between">
            <flux:label>SEO Title</flux:label>
            <x-ai-button wire:click="generateSeoTitle" wire:loading.attr="disabled" wire:target="generateSeoTitle"
                loadingText="Generating...">
                Generate SEO Title
            </x-ai-button>
        </div>
        <flux:input wire:model.blur="metaTitle" type="text" placeholder="Enter SEO title (50-60 characters)" />
        <flux:error name="metaTitle" />
        @if ($metaTitle)
            <flux:text size="sm"
                class="{{ strlen($metaTitle) > 60 ? 'text-red-600 dark:text-red-400' : 'text-gray-600 dark:text-gray-400' }}">
                {{ strlen($metaTitle) }} characters
            </flux:text>
        @endif
    </flux:field>

    @if (count($titleSuggestions) > 0)
        <div class="space-y-2">
            <flux:text size="sm" class="font-medium">Alternative Suggestions:</flux:text>
            @foreach ($titleSuggestions as $suggestion)
                <div wire:click="useTitleSuggestion('{{ addslashes($suggestion) }}')"
                    class="cursor-pointer rounded-lg border border-gray-200 p-3 hover:border-blue-500 hover:bg-blue-50 dark:border-gray-700 dark:hover:border-blue-500 dark:hover:bg-blue-900/20">
                    <flux:text size="sm">{{ $suggestion }} <span class="text-gray-500">({{ strlen($suggestion) }}
                            chars)</span></flux:text>
                </div>
            @endforeach
        </div>
    @endif

    <flux:field>
        <div class="flex items-center justify-between">
            <flux:label>Meta Description</flux:label>
            @if ($contentField)
                <x-ai-button wire:click="generateMetaDescription" wire:loading.attr="disabled"
                    wire:target="generateMetaDescription" loadingText="Generating...">
                    Generate Meta Description
                </x-ai-button>
            @endif
        </div>
        <flux:textarea wire:model.blur="metaDescription" placeholder="Enter meta description (150-160 characters)"
            rows="3" />
        <flux:error name="metaDescription" />
        @if ($metaDescription)
            <flux:text size="sm"
                class="{{ strlen($metaDescription) > 160 ? 'text-red-600 dark:text-red-400' : 'text-gray-600 dark:text-gray-400' }}">
                {{ strlen($metaDescription) }} characters
            </flux:text>
        @endif
    </flux:field>

    @if (count($descriptionSuggestions) > 0)
        <div class="space-y-2">
            <flux:text size="sm" class="font-medium">Alternative Suggestions:</flux:text>
            @foreach ($descriptionSuggestions as $suggestion)
                <div wire:click="useDescriptionSuggestion('{{ addslashes($suggestion) }}')"
                    class="cursor-pointer rounded-lg border border-gray-200 p-3 hover:border-blue-500 hover:bg-blue-50 dark:border-gray-700 dark:hover:border-blue-500 dark:hover:bg-blue-900/20">
                    <flux:text size="sm">{{ $suggestion }} <span class="text-gray-500">({{ strlen($suggestion) }}
                            chars)</span></flux:text>
                </div>
            @endforeach
        </div>
    @endif

    <flux:field>
        <flux:label>Keywords</flux:label>
        <flux:text size="sm" class="text-gray-600 dark:text-gray-400">Add keywords relevant to your
            content. Type your own or click suggested keywords below.</flux:text>

        <div class="flex gap-2 mt-2">
            <flux:input wire:model="newKeyword" wire:keydown.enter.prevent="addNewKeyword" type="text"
                placeholder="Type a keyword and press Enter" class="flex-1" />
            <flux:button type="button" wire:click="addNewKeyword" variant="primary">
                Add
            </flux:button>
        </div>

        @if (count($keywords) > 0)
            <div class="flex flex-wrap gap-2 mt-3">
                @foreach ($keywords as $index => $keyword)
                    <flux:badge variant="outline" class="group">
                        {{ $keyword }}
                        <button type="button" wire:click="removeKeyword({{ $index }})"
                            class="ml-1 text-gray-500 hover:text-red-600">
                            ×
                        </button>
                    </flux:badge>
                @endforeach
            </div>
        @else
            <flux:text size="sm" class="text-gray-500 dark:text-gray-500 italic mt-2">No keywords added
                yet.</flux:text>
        @endif
    </flux:field>

    <flux:separator />

    <div class="flex items-center justify-between">
        <flux:heading size="md">SEO Analysis</flux:heading>
        <flux:button wire:click="analyzeSeo" size="sm" variant="primary" wire:loading.attr="disabled"
            wire:target="analyzeSeo" icon="search">
            <span wire:loading.remove wire:target="analyzeSeo">Analyze SEO</span>
            <span wire:loading wire:target="analyzeSeo">Analyzing...</span>
        </flux:button>
    </div>

    @if ($seoAnalysis)
        <div class="space-y-4 rounded-lg border border-gray-200 p-4 dark:border-gray-700">
            <div class="flex items-center justify-between">
                <flux:heading size="sm">SEO Score</flux:heading>
                <flux:badge size="lg"
                    :variant="$seoAnalysis['score'] >= 80 ? 'success' : ($seoAnalysis['score'] >= 60 ? 'warning' : 'danger')">
                    {{ $seoAnalysis['score'] }}/100
                </flux:badge>
            </div>

            @if (count($seoAnalysis['keywords']) > 0)
                <div>
                    <flux:text size="sm" class="font-medium mb-2">Suggested Keywords (click to add):</flux:text>
                    <div class="flex flex-wrap gap-2">
                        @foreach ($seoAnalysis['keywords'] as $keyword)
                            <flux:badge variant="outline"
                                class="cursor-pointer hover:bg-blue-50 hover:border-blue-500 dark:hover:bg-blue-900/20 dark:hover:border-blue-500 {{ in_array($keyword, $keywords) ? 'opacity-50' : '' }}"
                                wire:click="addKeyword('{{ addslashes($keyword) }}')">
                                {{ $keyword }}
                                @if (in_array($keyword, $keywords))
                                    <span class="ml-1">✓</span>
                                @else
                                    <span class="ml-1">+</span>
                                @endif
                            </flux:badge>
                        @endforeach
                    </div>
                </div>
            @endif

            @if (count($seoAnalysis['issues']) > 0)
                <div>
                    <flux:text size="sm" class="font-medium text-red-600 dark:text-red-400 mb-2">Issues:
                    </flux:text>
                    <ul class="list-disc space-y-1 pl-5">
                        @foreach ($seoAnalysis['issues'] as $issue)
                            <li>
                                <flux:text size="sm" class="text-red-600 dark:text-red-400">{{ $issue }}
                                </flux:text>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (count($seoAnalysis['recommendations']) > 0)
                <div>
                    <flux:text size="sm" class="font-medium text-blue-600 dark:text-blue-400 mb-2">
                        Recommendations:</flux:text>
                    <ul class="list-disc space-y-1 pl-5">
                        @foreach ($seoAnalysis['recommendations'] as $recommendation)
                            <li>
                                <flux:text size="sm">{{ $recommendation }}</flux:text>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
    @endif

    <flux:button wire:click="save" variant="filled" class="w-full">
        Save SEO Settings
    </flux:button>
</div>
