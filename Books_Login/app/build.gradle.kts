plugins {
    alias(libs.plugins.android.application)
}

android {
    namespace = "com.example.books_login"
    compileSdk {
        version = release(36) {
            minorApiLevel = 1
        }
    }
//So fazer uma vez e a seguir sync
    buildFeatures { viewBinding=true }

    defaultConfig {
        applicationId = "com.example.books_login"
        minSdk = 27
        targetSdk = 36
        versionCode = 1
        versionName = "1.0"

        testInstrumentationRunner = "androidx.test.runner.AndroidJUnitRunner"
    }

    buildTypes {
        release {
            optimization {
                enable = false
            }
        }
    }
    compileOptions {
        sourceCompatibility = JavaVersion.VERSION_11
        targetCompatibility = JavaVersion.VERSION_11
    }
}

dependencies {
    implementation(libs.activity.ktx)
    implementation(libs.appcompat)
    implementation(libs.constraintlayout)
    implementation(libs.material)
    testImplementation(libs.junit)
    androidTestImplementation(libs.espresso.core)
    androidTestImplementation(libs.ext.junit)
}