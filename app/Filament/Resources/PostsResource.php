<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PostsResource\Pages;
use App\Filament\Resources\PostsResource\RelationManagers;
use App\Models\Posts;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TagsInput;  
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ColorColumn;
use Filament\Tables\Columns\CheckboxColumn;
use Filament\Tables\Columns\ImageColumn;
use App\Models\Categories;

class PostsResource extends Resource
{
    protected static ?string $model = Posts::class;

    protected static ?string $navigationIcon = 'heroicon-o-newspaper';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title')
                    ->label('Title')
                    ->required(),
                TextInput::make('slug')
                    ->label('Slug')
                    ->required(),
                Select::make('category_id')
                    ->label('Category')
                    ->relationship('category', 'name')
                    ->options(Categories::all()->pluck('name', 'id')->toArray())
                    ->required(),
                ColorPicker::make('color')
                    ->label('Color')
                    ->default('#000000')
                    ->required(),
                
                MarkdownEditor::make('content')
                    ->label('Content')
                    ->required(),

                FileUpload::make('thumbnail')
                    ->label('Thumbnail')
                    ->image()
                    ->disk('public')->directory('thumbnails')
                    ->required(),
                
                
                
                TagsInput::make('tags') 
                    ->label('Tags')
                    ->placeholder('Add a tag')
                    // ->tagify()
                    ->required(),
                Checkbox::make('is_published')
                    ->label('Is Published'),
                
                
                
                
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->searchable()
                    ->sortable(),  
                TextColumn::make('title')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('category.name')
                    ->label('Category')
                    ->searchable()
                    ->sortable(),
                ColorColumn::make('color')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('slug')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('tags')
                    ->searchable()
                    ->sortable(),
                CheckboxColumn::make('is_published')
                    ->searchable()
                    ->sortable(),
                ImageColumn::make('thumbnail')
                    ->searchable()
                    ->sortable(),

            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePosts::route('/create'),
            'edit' => Pages\EditPosts::route('/{record}/edit'),
        ];
    }
}
