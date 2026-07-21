<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // This migration merges additional columns into an existing users table.
        if (!Schema::hasTable('users')) {
            // If users table does not exist, create baseline compatible with existing app.
            Schema::create('users', function (Blueprint $table) {
                $table->id();
                $table->string('name', 150);
                $table->string('email', 255)->unique();
                $table->timestamp('email_verified_at')->nullable();
                $table->string('password');
                $table->rememberToken();
                $table->timestamps();
            });
        }

        Schema::table('users', function (Blueprint $table) {
            // Add role_id if missing
            if (!Schema::hasColumn('users', 'role_id')) {
                $table->unsignedBigInteger('role_id')->nullable()->after('id');
                $table->index('role_id');
            }

            // Add username if missing
            if (!Schema::hasColumn('users', 'username')) {
                $table->string('username', 80)->nullable()->unique()->after('name');
            } else {
                // ensure unique index exists
                try {
                    $table->unique('username');
                } catch (\Exception $e) {
                    // ignore if index exists or cannot be created
                }
            }

            // Add phone if missing
            if (!Schema::hasColumn('users', 'phone')) {
                $table->string('phone', 30)->nullable()->after('remember_token');
            }

            // Add last_login_at if missing
            if (!Schema::hasColumn('users', 'last_login_at')) {
                $table->timestamp('last_login_at')->nullable()->after('phone');
            }

            // Add soft deletes if missing
            if (!Schema::hasColumn('users', 'deleted_at')) {
                $table->softDeletes();
            }
        });

        // Add foreign key for role_id if it exists and FK not already present
        if (Schema::hasColumn('users', 'role_id')) {
            // Try to create foreign key safely
            try {
                DB::statement('ALTER TABLE `users` ADD CONSTRAINT `users_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles`(`id`) ON DELETE SET NULL');
            } catch (\Exception $e) {
                // ignore if constraint already exists
            }
        }
    }

    public function down(): void
    {
        // revert added columns if they exist
        if (Schema::hasTable('users')) {
            Schema::table('users', function (Blueprint $table) {
                if (Schema::hasColumn('users', 'role_id')) {
                    // drop foreign key if exists
                    try {
                        $table->dropForeign(['role_id']);
                    } catch (\Exception $e) {
                        // ignore
                    }
                    $table->dropIndex(['role_id']);
                    $table->dropColumn('role_id');
                }

                if (Schema::hasColumn('users', 'username')) {
                    try {
                        $table->dropUnique(['username']);
                    } catch (\Exception $e) {
                        // ignore
                    }
                    $table->dropColumn('username');
                }

                if (Schema::hasColumn('users', 'phone')) {
                    $table->dropColumn('phone');
                }

                if (Schema::hasColumn('users', 'last_login_at')) {
                    $table->dropColumn('last_login_at');
                }

                if (Schema::hasColumn('users', 'deleted_at')) {
                    try {
                        $table->dropSoftDeletes();
                    } catch (\Exception $e) {
                        // ignore
                    }
                }
            });
        }
    }
};
