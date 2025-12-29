# Image optimization helper (PowerShell)
# Requires ImageMagick (magick) installed and available in PATH.
# Usage: .\optimize-images.ps1 -Path "public/assets/img" -Quality 82
param(
    [string]$Path = "public/assets/img",
    [int]$Quality = 82
)

if (-not (Get-Command magick -ErrorAction SilentlyContinue)) {
    Write-Host "ImageMagick 'magick' not found in PATH. Install ImageMagick or use another tool." -ForegroundColor Yellow
    exit 1
}

Write-Host "Optimizing images in $Path with quality $Quality..."
Get-ChildItem -Path $Path -Include *.jpg,*.jpeg,*.png -Recurse | ForEach-Object {
    $file = $_.FullName
    $ext = $_.Extension.ToLower()
    if ($ext -in '.jpg','.jpeg') {
        magick convert $file -strip -interlace Plane -quality $Quality $file
        Write-Host "Optimized (jpg): $file"
    } elseif ($ext -eq '.png') {
        # PNG optimization (convert + pngquant if available)
        magick convert $file -strip -quality $Quality $file
        Write-Host "Optimized (png): $file"
    }
}

Write-Host "Done. Consider verifying visual quality and committing optimized assets." -ForegroundColor Green
