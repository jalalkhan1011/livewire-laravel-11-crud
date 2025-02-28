<?php

namespace App\Livewire;

use App\Models\news;
use Livewire\Component;

class Crud extends Component
{
    public $posts, $title, $content, $post_id;
    public $isOpen = false;

    public function render()
    {
        $this->posts = news::all();
        return view('livewire.crud');
    }

    public function create()
    {
        $this->resetFields();
        $this->openModal();
    }

    public function store()
    {
        $this->validate([
            'title' => 'required',
            'content' => 'required',
        ]);

        news::updateOrCreate(['id' => $this->post_id], [
            'title' => $this->title,
            'content' => $this->content,
        ]);

        session()->flash('message', $this->post_id ? 'Post updated successfully.' : 'Post created successfully.');

        $this->closeModal();
        $this->resetFields();
    }

    public function edit($id)
    {
        $post = news::findOrFail($id);
        $this->post_id = $id;
        $this->title = $post->title;
        $this->content = $post->content;

        $this->openModal();
    }

    public function delete($id)
    {
        news::findOrFail($id)->delete();
        session()->flash('message', 'Post deleted successfully.');
    }

    public function openModal()
    {
        $this->isOpen = true;
    }

    public function closeModal()
    {
        $this->isOpen = false;
    }

    public function resetFields()
    {
        $this->post_id = '';
        $this->title = '';
        $this->content = '';
    }
}
