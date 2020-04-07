from arcgis.gis import GIS

# Python Standard Library Modules
from pathlib import Path
from zipfile import ZipFile

public_data_item_id = '093b7d4df3e94af497875e72221f5bc3'

anon_gis = GIS()

data_item = anon_gis.content.get(public_data_item_id)

# `ContentManager.get` will return `None` if there is no Item with ID `093b7d4df3e94af497875e72221f5bc3`
data_item

# configure where we should save our data, and where the ZIP file is located

data_path = Path('./data')

if not data_path.exists():
    data_path.mkdir()

zip_path = data_path.joinpath('FL_Hub_Datasets.zip')
extract_path = data_path.joinpath('FL_Hub_datasets')

data_item.download(save_path=data_path)

zip_file = ZipFile(zip_path)
zip_file.extractall(path=extract_path)

list(file.name for file in extract_path.glob('*'))
