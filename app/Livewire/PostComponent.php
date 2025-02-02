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

    public function edit($id)
    {
        $post = Post::findOrFail($id);
        $this->post_id = $id;
        $this->title = $post->title;
        $this->body = $post->body;

        $this->updateMode = true;
    }

    public function cancel()
    {
        $this->updateMode = false;
        $this->resetInputFields();
    }

    public function update()
    {
        $this->validate([
            'title' => 'required',
            'body' => 'required'
        ]);

        if ($this->post_id) {
            $post = Post::findOrfail($this->post_id);
            $post->update([
                'title' => $this->title,
                'body' => $this->body
            ]);
        }

        $this->updateMode = false;

        session()->flash('message', 'Post Updated Successfully');
        $this->resetInputFields();
    }
}
