import pandas as pd
import sys

csv_file = sys.argv[1]
parquet_file = sys.argv[2]
df = pd.read_csv(csv_file)
df.to_parquet(parquet_file, index=False)