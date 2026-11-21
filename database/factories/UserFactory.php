<?php

namespace Database\Factories;

use App\Enums\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<User>
 */
class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition(): array
    {
        return [
            'nom' => fake()->lastName(),
            'prenom' => fake()->firstName(),
            'email' => fake()->unique()->safeEmail(),
            // Le cast « hashed » du modèle hache le mot de passe.
            'password' => 'password',
            'role' => Role::ETUDIANT,
        ];
    }

    public function admin(): static
    {
        return $this->state(fn (): array => ['role' => Role::ADMIN]);
    }
}
