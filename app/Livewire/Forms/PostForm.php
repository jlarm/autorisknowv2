<?php

declare(strict_types=1);

namespace App\Livewire\Forms;

use App\Enums\Status;
use App\Enums\Visibility;
use App\Models\Post;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;
use Livewire\Attributes\Validate;
use Livewire\Form;

final class PostForm extends Form
{
    public ?Post $post = null;

    #[Validate('required|string|min:3|max:255')]
    public string $title = '';

    public string $slug = '';

    #[Validate('nullable|string')]
    public ?string $content = '';

    public $featuredImage;

    #[Validate('nullable|url')]
    public ?string $externalLink = '';

    public Status $status = Status::Draft;

    public Visibility $visibility = Visibility::PUBLIC;

    #[Validate('required|date')]
    public string $publishedAt = '';

    /**
     * @return array<string, array<int, mixed>>
     */
    public function rules(): array
    {
        $uniqueRule = Rule::unique('posts', 'slug');

        if ($this->post instanceof Post) {
            $uniqueRule->ignore($this->post->id);
        }

        return [
            'slug' => [
                'required',
                'string',
                'min:3',
                'max:255',
                $uniqueRule,
            ],
            'featuredImage' => [
                'nullable',
                function ($attribute, $value, $fail) {
                    if ($value === null) {
                        return;
                    }

                    if (is_string($value)) {
                        return;
                    }

                    if (! $value instanceof \Illuminate\Http\UploadedFile) {
                        $fail('The featured image must be a valid file.');

                        return;
                    }

                    if (! in_array($value->getMimeType(), ['image/jpeg', 'image/png', 'image/gif', 'image/webp'])) {
                        $fail('The featured image must be an image.');

                        return;
                    }

                    if ($value->getSize() > 10240 * 1024) {
                        $fail('The featured image must not be greater than 10MB.');
                    }
                },
            ],
            'status' => ['required', new Enum(Status::class)],
            'visibility' => ['required', new Enum(Visibility::class)],
        ];
    }

    public function setPost(Post $post): void
    {
        $this->post = $post;

        $this->title = $post->title;
        $this->slug = $post->slug;
        $this->content = $post->content;
        $this->externalLink = $post->external_link;
        $this->status = $post->status;
        $this->visibility = $post->visibility;
        $this->publishedAt = $post->published_at->format('Y-m-d');
        $this->featuredImage = $post->featured_image;
    }

    public function save(): void
    {
        $this->slug = (string) str($this->title)->slug();

        $this->validate();

        $featuredImagePath = null;
        if ($this->featuredImage) {
            $featuredImagePath = $this->featuredImage->store('posts', 'public');
        }

        Post::query()->create([
            'title' => $this->title,
            'slug' => $this->slug,
            'content' => $this->content,
            'featured_image' => $featuredImagePath,
            'external_link' => $this->externalLink,
            'status' => $this->status,
            'visibility' => $this->visibility,
            'published_at' => $this->publishedAt,
        ]);
    }

    public function update(): void
    {
        $this->validate();

        $data = [
            'title' => $this->title,
            'slug' => $this->slug,
            'content' => $this->content,
            'external_link' => $this->externalLink,
            'status' => $this->status,
            'visibility' => $this->visibility,
            'published_at' => $this->publishedAt,
        ];

        if ($this->featuredImage && ! is_string($this->featuredImage)) {
            $data['featured_image'] = $this->featuredImage->store('posts', 'public');
        }

        $this->post->update($data);
    }
}
