#
# Shawn Schwartz, 2019
# <shawnschwartz@ucla.edu>
# Alfaro Lab

# Hopscotch Mosaic Auto Crop and Preprocess
for k in *.jpg; do convert $k -crop 315x210+0+88 $k; done

# Square Mosaic Auto Crop and Preprocess
for k in *.jpg; do convert $k -crop 200x200+0+158 $k; done
