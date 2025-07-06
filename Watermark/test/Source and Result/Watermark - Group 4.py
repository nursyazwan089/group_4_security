from PIL import Image, ImageDraw, ImageFont

def add_watermark(input_image_path, output_image_path, watermark_text="SECURE"):
    image = Image.open(input_image_path).convert("RGBA")
    watermark = Image.new("RGBA", image.size, (0, 0, 0, 0))
    
    font_size = int(min(image.size) / 10)
    try:
        font = ImageFont.truetype("arial.ttf", font_size)
    except IOError:
        font = ImageFont.load_default()

    draw = ImageDraw.Draw(watermark)
    
    # Use textbbox instead of deprecated textsize
    text_bbox = draw.textbbox((0, 0), watermark_text, font=font)
    text_width = text_bbox[2] - text_bbox[0]
    text_height = text_bbox[3] - text_bbox[1]

    x = image.width - text_width - 10
    y = image.height - text_height - 10

    draw.text((x, y), watermark_text, font=font, fill=(255, 0, 0, 128))
    combined = Image.alpha_composite(image, watermark)
    combined.convert("RGB").save(output_image_path, "JPEG")
    print(f"Watermarked image saved to: {output_image_path}")

# Change filename to match your image
add_watermark("Cat_August_2010-4.jpg", "output.jpg")
