import pandas as pd
import sys

parquet_file = sys.argv[1]
csv_file = sys.argv[2]
print(parquet_file)
df = pd.read_parquet(parquet_file)
df.to_csv(csv_file, index=False)
