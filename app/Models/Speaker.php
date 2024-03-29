<?php

namespace App\Models;

use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Speaker extends Model
{
    use HasFactory;

    const QUALIFICATIONS = [
        'business-leader' => 'Business Leader',
        'christmas' => 'Christmas',
        'first-time'=> 'First Time Speaker',
        'hometown-hero'=> 'Hometown Hero',
        'humanitarian'=> 'Works in Humanitarian Field',
        'innovator' => 'Innovator',
        'community-builder' => 'Community Builder',
        'tech-enthusiast' => 'Tech Enthusiast',
        'environmentalist' => 'Environmentalist',
        'fitness-guru' => 'Fitness Guru',
        'art-enthusiast' => 'Art Enthusiast',
        'bookworm' => 'Bookworm',
        'volunteer' => 'Volunteer',
        'fashionista' => 'Fashionista',
        'music-lover' => 'Music Lover',
        'traveler' => 'World Traveler',
        'pet-lover' => 'Pet Lover',
        'foodie' => 'Foodie',
        'educator' => 'Educator',
        'entrepreneur' => 'Entrepreneur',
        'startup-enthusiast' => 'Startup Enthusiast',
        'coding-ninja' => 'Coding Ninja',
        'gamer' => 'Gamer',
        'science-geek' => 'Science Geek',
        'podcast-host' => 'Podcast Host',
        'motivational-speaker' => 'Motivational Speaker',
        'film-buff' => 'Film Buff',
        'language-aficionado' => 'Language Aficionado',
        'history-buff' => 'History Buff',
        'sports-fanatic' => 'Sports Fanatic',
        'gardening-enthusiast' => 'Gardening Enthusiast',
        'coffee-connoisseur' => 'Coffee Connoisseur',
        'photography-enthusiast' => 'Photography Enthusiast',
        'family-person' => 'Family Person',
        'future-philanthropist' => 'Future Philanthropist',
    ];

    protected $casts = [
        'id' => 'integer',
        'qualifications' => 'array'
    ];

    public function conferences(): BelongsToMany
    {
        return $this->belongsToMany(Conference::class);
    }

    public function talks(): HasMany
    {
        return $this->hasMany(Talk::class);
    }

    public static function getForm():array
    {
        return [
            Section::make('Speaker Details')
            ->schema([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                FileUpload::make('avatar')
                    ->avatar()
                    ->imageEditor()
                    ->maxSize(1024 * 1024 * 10)
                    ->directory('avatars')
                    ->columnSpanFull(),
                TextInput::make('email')
                    ->email()
                    ->required()
                    ->maxLength(255),
                RichEditor::make('bio')
                    ->required()
                    ->maxLength(65535)
                    ->columnSpanFull(),
                TextInput::make('twitter_handle')
                    ->required()
                    ->maxLength(255),
            ]),
            CheckboxList::make('qualifications')
                ->columnSpanFull()
                ->searchable()
                ->bulkToggleable()
                ->options(self::QUALIFICATIONS)
                ->descriptions([
                    'business-leader' => 'Business Leader lorem lorem',
                    'christmas' => 'Christmas lorem lorem',
                ])->columns(3)
        ];
    }

    public static function getQualifications():array
    {
        return [
            'business-leader' => 'Business Leader',
            'christmas' => 'Christmas',
            'first-time'=> 'First Time Speaker',
            'hometown-hero'=> 'Hometown Hero',
            'humanitarian'=> 'Works in Humanitarian Field',
            'innovator' => 'Innovator',
            'community-builder' => 'Community Builder',
            'tech-enthusiast' => 'Tech Enthusiast',
            'environmentalist' => 'Environmentalist',
            'fitness-guru' => 'Fitness Guru',
            'art-enthusiast' => 'Art Enthusiast',
            'bookworm' => 'Bookworm',
            'volunteer' => 'Volunteer',
            'fashionista' => 'Fashionista',
            'music-lover' => 'Music Lover',
            'traveler' => 'World Traveler',
            'pet-lover' => 'Pet Lover',
            'foodie' => 'Foodie',
            'educator' => 'Educator',
            'entrepreneur' => 'Entrepreneur',
            'startup-enthusiast' => 'Startup Enthusiast',
            'coding-ninja' => 'Coding Ninja',
            'gamer' => 'Gamer',
            'science-geek' => 'Science Geek',
            'podcast-host' => 'Podcast Host',
            'motivational-speaker' => 'Motivational Speaker',
            'film-buff' => 'Film Buff',
            'language-aficionado' => 'Language Aficionado',
            'history-buff' => 'History Buff',
            'sports-fanatic' => 'Sports Fanatic',
            'gardening-enthusiast' => 'Gardening Enthusiast',
            'coffee-connoisseur' => 'Coffee Connoisseur',
            'photography-enthusiast' => 'Photography Enthusiast',
            'family-person' => 'Family Person',
            'future-philanthropist' => 'Future Philanthropist',
        ];
    }
}
