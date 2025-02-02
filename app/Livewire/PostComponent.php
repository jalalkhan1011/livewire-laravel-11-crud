<?php

namespace App\Livewire;

use App\Models\Post;
use Livewire\Component;

class PostComponent extends Component
{
    public $posts, $title, $body, $post_id;
    public $updateMode = false;

    public function render()
    {
        $this->posts = Post::all();

        return view('livewire.post-component');
    }

    private function resetInputFields()
    {
        $this->title = '';
        $this->body = '';
    }

    public function store()
    {
        $this->validate([
            'title' => 'required',
            'body' => 'required'
        ]);

        Post::create([
            'title' => $this->title,
            'body' => $this->body
        ]);

        session()->flash('message', 'Post Created Suceessfully');

        $this->resetInputFields();
    }
}
